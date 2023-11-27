<?php

namespace App\Http\Controllers\admin;

use App\Exports\PatientReportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Barangay;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $barangays = Barangay::all();
        $query = $request->input('search');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        $patients = Patient::with('barangay')
            ->when($query, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $numericSearch = is_numeric($request->input('search'));
                    $query->when($numericSearch, function ($query) use ($request) {
                        $query->orWhere('id', $request->input('search'));
                    }, function ($query) use ($request) {
                        $query->orWhere('first_name', 'like', '%' . $request->input('search') . '%')
                            ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');

                        // Add condition to search by barangay name
                        $query->orWhereHas('barangay', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('search') . '%');
                        });

                        // Add condition to search by gender
                        $gender = strtoupper($request->input('search'));
                        $query->orWhere('gender', $gender);
                    });
                });
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.patients.index', compact('patients', 'barangays', 'query', 'entries', 'column', 'order'));
    }
    public function create()
    {
        $barangays = Barangay::all();

        return view('patients.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'birthdate' => 'required|date',
                'age' => 'required|integer',
                'gender' => 'required|string',
                'barangay_id' => 'required|exists:barangays,id',
                'blood_pressure' => 'nullable|string',
                'heart_rate' => 'nullable|integer',
                'weight' => 'nullable|numeric',
                'height' => 'nullable|numeric',
            ]);
            $request->merge(['created_by' => auth()->id()]);
            Patient::create($request->all());

            return redirect()->route('patients.index')->with('success', 'Patient created successfully');
        } catch (\Exception $e) {
            return redirect()->route('patients.index')->with('error', 'An error occurred while creating the Patient: ' . $e->getMessage());
        }
    }
    public function edit(Patient $patient)
    {
        $barangays = Barangay::all();

        return view('patients.edit', compact('patient', 'barangays'));
    }
    public function update(Request $request, Patient $patient)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'birthdate' => 'required|date',
                'age' => 'required|integer',
                'gender' => 'required|string',
                'barangay_id' => 'required|exists:barangays,id',
                'blood_pressure' => 'nullable|string',
                'heart_rate' => 'nullable|integer',
                'weight' => 'nullable|numeric',
                'height' => 'nullable|numeric',
            ]);
            $request->merge(['updated_by' => auth()->id()]);
            $patient->update($request->all());

            return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('patients.index')->with('error', 'An error occurred while updating the Patient: ' . $e->getMessage());
        }
    }
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }

    public function generatePatientReport(Request $request)
    {
        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        $fromDate = $request->input('from');
        $toDate = $request->input('to');
        $exportFormat = $request->input('exportFormat');

        // Get data for the patient report within the date range
        $reportData = Patient::whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No patient data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'patient_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file with landscape orientation (setPaper method)
            $pdf = PDF::loadView('admin.patients.patient-report-pdf', compact('reportData', 'fromDate', 'toDate'))
                ->setPaper('a4', 'landscape'); // Adjust paper size and orientation as needed
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'patient_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            // Example: Excel::store(new PatientReportExport($reportData, $fromDate, $toDate), 'reports/' . $excelFileName, 'public');

            // Provide the file download link
            return response()->download(public_path('reports/' . $excelFileName))->deleteFileAfterSend(true);
        }

        return redirect()->back()
            ->with('success', 'Patient report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
