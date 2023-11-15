<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\BarangayMedicine;
use Illuminate\Support\Facades\Auth;
use App\Exports\BarangayMedicineReportExport;
use Illuminate\Support\Facades\Response;

class BarangayMedicineController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('search', '');

        if ($user->hasRole('admin')) {
            $barangayMedicines = BarangayMedicine::where('stocks', '>', 0); // Only fetch medicines with stock greater than 0
        } elseif ($user->hasRole('bhw')) {
            $barangayMedicines = BarangayMedicine::where('barangay_id', $user->barangay_id)
                ->where('stocks', '>', 0);
        }

        if ($query) {
            $barangayMedicines->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('barangay', function ($subquery) use ($query) {
                    $subquery->where('name', 'like', '%' . $query . '%');
                })->orWhereHas('medicine', function ($subquery) use ($query) {
                    $subquery->where('generic_name', 'like', '%' . $query . '%')
                        ->orWhere('brand_name', 'like', '%' . $query . '%');
                });
            });
        }

        $barangayMedicines = $barangayMedicines->paginate(10);

        return view('barangay.barangay_medicines.index', compact('barangayMedicines', 'query'));
    }

    public function generateBarangayMedicineReport(Request $request)
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

        // Get data for the barangay medicine report within the date range
        $reportData = BarangayMedicine::with(['barangay', 'medicine'])
            ->where('stocks', '>', 0) // Only include medicines with stock greater than 0
            ->when($user->isBHW(), function ($query) use ($user) {
                // Limit BHW users to medicines from their own barangay
                $query->where('barangay_id', $user->barangay_id);
            })
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No barangay medicine data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'barangay_medicine_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = Pdf::loadView('barangay.barangay_medicines.barangay-medicine-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'barangay_medicine_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            // Replace 'BarangayMedicineReportExport' with the actual export class if you have one
            // (you may need to create it using artisan command: php artisan make:export BarangayMedicineReportExport)
            return (new \Maatwebsite\Excel\Excel\BarangayMedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Barangay medicine report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
