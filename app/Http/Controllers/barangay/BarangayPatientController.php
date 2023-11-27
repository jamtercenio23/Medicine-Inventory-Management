<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayPatient;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BarangayPatientReportExport;
use Illuminate\Support\Facades\Response;

class BarangayPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $gender = $request->input('gender');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $user = Auth::user();

        $barangayPatients = BarangayPatient::query();

        if ($user) {
            // If the user is a BHW, retrieve patients from their barangay
            if ($user->isBHW()) {
                $barangayPatients->where('barangay_id', $user->barangay_id);
            }

            // For Admin, retrieve patients from all barangays
            if ($user->isAdmin()) {
                $barangayPatients->orWhere('id', '>', 0); // A condition to include all records, adjust it as per your needs
            }
        } else {
            // For unauthenticated users, don't allow access to patient data
            abort(403, 'Unauthorized');
        }

        $barangayPatients = $barangayPatients
            ->where(function ($queryBuilder) use ($request) {
                // Apply the search condition for first_name, last_name, and barangay name
                $queryBuilder->where('first_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhereHas('barangay', function ($subquery) use ($request) {
                        $subquery->where('name', 'like', '%' . $request->input('search') . '%');
                    })
                    ->orWhere('id', $request->input('search'))
                    ->orWhere('gender', $request->input('search'));
            })
            ->when($gender, function ($queryBuilder) use ($gender) {
                $queryBuilder->whereHas('barangay', function ($subquery) use ($gender) {
                    $subquery->where('gender', $gender);
                });
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        $barangays = Barangay::all();

        return view('barangay.barangay_patients.index', compact('barangayPatients', 'barangays', 'query', 'entries', 'column', 'order'));
    }
    public function create()
    {
        $user = Auth::user();
        $barangays = ($user && $user->isAdmin()) ? Barangay::all() : [$user->barangay];

        return view('barangay.barangay_patients.create', compact('barangays'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'barangay_id' => 'required|exists:barangays,id',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'birthdate' => 'required|date',
                'age' => 'required|integer',
                'gender' => 'required|in:Male,Female',
            ]);

            $user = Auth::user();

            if ($user->isBHW()) {
                // If the user is a BHW, set the patient's barangay to the BHW's barangay
                $request['barangay_id'] = $user->barangay_id;
            }

            BarangayPatient::create($request->all());

            return redirect()->route('barangay-patients.index')->with('success', 'Patient created successfully');
        } catch (\Exception $e) {
            return redirect()->route('barangay-patients.index')->with('error', 'An error occurred while creating the patient: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $barangayPatient = BarangayPatient::findOrFail($id);
        $barangays = Barangay::all();

        return view('barangay.barangay_patients.edit', compact('barangayPatient', 'barangays'));
    }
    public function update(Request $request, BarangayPatient $barangayPatient)
    {
        try {
            $request->validate([
                'barangay_id' => 'required|exists:barangays,id',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'birthdate' => 'required|date',
                'age' => 'required|integer',
                'gender' => 'required|in:Male,Female',
            ]);

            $barangayPatient->update($request->all());

            return redirect()->route('barangay-patients.index')->with('success', 'Patient updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('barangay-patients.index')->with('error', 'An error occurred while updating the patient: ' . $e->getMessage());
        }
    }
    public function destroy(BarangayPatient $barangayPatient)
    {
        $barangayPatient->delete();

        return redirect()->route('barangay-patients.index')->with('success', 'Patient deleted successfully');
    }

    public function generateBarangayPatientReport(Request $request)
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

        $user = Auth::user();

        // Get data for the barangay patient report within the date range
        $reportData = BarangayPatient::whereBetween('created_at', [$fromDate, $toDate])
            ->when($user->isBHW(), function ($query) use ($user) {
                // Limit BHW users to patients from their own barangay
                $query->where('barangay_id', $user->barangay_id);
            })
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No barangay patient data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'barangay_patient_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('barangay.barangay_patients.barangay-patient-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'barangay_patient_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            // Replace 'BarangayPatientReportExport' with the actual export class if you have one
            // (you may need to create it using artisan command: php artisan make:export BarangayPatientReportExport)
            return (new \Maatwebsite\Excel\Excel\BarangayPatientReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Barangay patient report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
