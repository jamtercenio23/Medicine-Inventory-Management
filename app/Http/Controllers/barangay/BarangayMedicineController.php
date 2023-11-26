<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\BarangayMedicine;
use Illuminate\Support\Facades\Auth;
use App\Exports\BarangayMedicineReportExport;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\ServiceProvider;
use Illuminate\Support\Facades\Session;

class BarangayMedicineController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('search', '');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

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

        $barangayMedicines = $barangayMedicines->orderBy($column, $order)->paginate($entries);

        return view('barangay.barangay_medicines.index', compact('barangayMedicines', 'query', 'entries', 'column', 'order'));
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
            $pdf->setPaper('a4', 'landscape');
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

    public function outOfStock(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('search', '');
        $category = $request->input('category', '');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        $outOfStockMedicines = $this->getOutOfStockMedicines($user, $query, $category)
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('barangay.barangay_medicines.out-of-stock', compact('outOfStockMedicines', 'query', 'entries', 'column', 'order'))
            ->with('success', 'Out of stock medicines retrieved successfully');
    }

    protected function getOutOfStockMedicines($user, $query, $category)
    {
        $queryBuilder = BarangayMedicine::where('stocks', '<=', 0);

        if ($user->hasRole('admin')) {
            // No additional conditions for admin
        } elseif ($user->hasRole('bhw')) {
            $queryBuilder->where('barangay_id', $user->barangay_id);
        }

        if ($query) {
            $queryBuilder->where(function ($queryBuilder) use ($query, $category) {
                $queryBuilder->whereHas('barangay', function ($subquery) use ($query) {
                    $subquery->where('name', 'like', '%' . $query . '%');
                })->orWhereHas('medicine', function ($subquery) use ($query, $category) {
                    $subquery->where('generic_name', 'like', '%' . $query . '%')
                        ->orWhere('brand_name', 'like', '%' . $query . '%')
                        ->orWhere('category', 'like', '%' . $category . '%');
                });
            });
        } elseif ($category) {
            $queryBuilder->whereHas('medicine', function ($subquery) use ($category) {
                $subquery->where('category', 'like', '%' . $category . '%');
            });
        }

        return $queryBuilder;
    }

    public function requestOutOfStock(Request $request, BarangayMedicine $barangayMedicine)
    {
        $request->validate([
            'expected_stocks' => 'required|integer',
            'distribution_schedule' => 'required|date',
        ]);

        // Ensure you are updating the correct fields in the database
        $barangayMedicine->update([
            'expected_stocks' => $request->input('expected_stocks'),
            'distribution_schedule' => $request->input('distribution_schedule'),
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Restock request submitted successfully');
    }
    public function generateBarangayOutOfStockReport(Request $request)
    {
        // If the request is GET, show the form
        $user = auth()->user(); // Retrieve the authenticated user

        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // Get data for the barangay out-of-stock report within the date range
        $reportData = BarangayMedicine::where('stocks', '<=', 0)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->when($user->isBHW(), function ($query) use ($user) {
                // Limit BHW users to medicines from their own barangay
                $query->where('barangay_id', $user->barangay_id);
            })
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No barangay out-of-stock data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($request->input('exportFormat') === 'pdf') {
            $pdfFileName = 'barangay_out_of_stock_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('barangay.barangay_medicines.barangay-out-of-stock-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        }

        if ($request->input('exportFormat') === 'excel') {
            $excelFileName = 'barangay_out_of_stock_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new BarangayMedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Barangay out-of-stock report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
    public function expired(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('search', '');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        // Fetch expired medicines based on user role and barangay
        $expiredMedicines = $this->getExpiredMedicines($user, $query);

        $expiredMedicines = $expiredMedicines
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('barangay.barangay_medicines.expired', compact('expiredMedicines', 'query', 'entries', 'column', 'order'))
            ->with('success', 'Expired medicines retrieved successfully');
    }
    protected function getExpiredMedicines($user, $query)
    {
        $queryBuilder = BarangayMedicine::where('expiration_date', '<', now());

        if ($user->hasRole('admin')) {
            // No additional conditions for admin
        } elseif ($user->hasRole('bhw')) {
            $queryBuilder->whereHas('barangay', function ($subquery) use ($user) {
                $subquery->where('id', $user->barangay_id);
            });
        }

        if ($query) {
            $queryBuilder->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('barangay', function ($subquery) use ($query) {
                    $subquery->where('name', 'like', '%' . $query . '%');
                })->orWhereHas('medicine', function ($subquery) use ($query) {
                    $subquery->where('generic_name', 'like', '%' . $query . '%')
                        ->orWhere('brand_name', 'like', '%' . $query . '%');
                });
            });
        }

        return $queryBuilder;
    }


    public function deleteExpired(Request $request)
    {
        $expiredMedicine = BarangayMedicine::where('expiration_date', '<', now())->first();

        if ($expiredMedicine) {
            $expiredMedicine->delete();
            return redirect()->route('barangay-medicines.expired')->with('success', 'Expired medicine deleted successfully');
        }

        return redirect()->route('barangay-medicines.expired')->with('error', 'No expired medicines found to delete');
    }
    public function generateBarangayExpiredReport(Request $request)
    {
        // If the request is GET, show the form
        if ($request->isMethod('get')) {
            return view('barangay.barangay_medicines.generate_barangay_expired_report');
        }

        // If the request is POST, handle the form submission

        $user = auth()->user(); // Retrieve the authenticated user

        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // Get data for the barangay expired report within the date range
        $reportData = BarangayMedicine::where('expiration_date', '<', now())
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->when($user->isBHW(), function ($query) use ($user) {
                // Limit BHW users to medicines from their own barangay
                $query->where('barangay_id', $user->barangay_id);
            })
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No barangay expired data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($request->input('exportFormat') === 'pdf') {
            $pdfFileName = 'barangay_expired_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('barangay.barangay_medicines.barangay-expired-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        }

        if ($request->input('exportFormat') === 'excel') {
            $excelFileName = 'barangay_expired_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new BarangayMedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Barangay expired report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
