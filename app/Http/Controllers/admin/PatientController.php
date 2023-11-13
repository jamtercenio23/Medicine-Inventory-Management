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

        $patients = Patient::with('barangay')
            ->when($query, function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
            })
            ->paginate($request->input('entries', 10));

        return view('admin.patients.index', compact('patients', 'barangays', 'query'));
    }

    // public function index(Request $request)
    // {
    //     $barangays = Barangay::all();
    //     $query = $request->input('search');
    //     $sort = $request->input('sort', 'id');
    //     $order = $request->input('order', 'asc');
    //     $patients = Patient::with('barangay')->when($query, function ($query) use ($request) {
    //         $query->where('first_name', 'like', '%' . $request->input('search') . '%')->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
    //     })->orderBy($sort === 'barangay' ? 'barangay_id' : $sort, $order)->paginate($request->input('entries', 10));
    //     return view('admin.patients.index', compact('patients', 'barangays', 'query', 'sort', 'order'));
    // }

    public function create()
    {
        $barangays = Barangay::all();

        return view('patients.create', compact('barangays'));
    }

    public function store(Request $request)
    {
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

        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient created successfully');
    }


    public function edit(Patient $patient)
    {
        $barangays = Barangay::all();

        return view('patients.edit', compact('patient', 'barangays'));
    }

    public function update(Request $request, Patient $patient)
    {
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

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
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

            // Generate and save the PDF file
            $pdf = PDF::loadView('admin.patients.patient-report-pdf', compact('reportData', 'fromDate', 'toDate'));
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
