<?php

namespace App\Http\Controllers\admin;

use App\Exports\MedicineReportExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Category;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Response;


class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now()->toDateString();
        $categories = Category::all();
        $query = $request->input('search');
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $entries = $request->input('entries', 10);

        $medicines = Medicine::with('category')
            ->when($query, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $numericSearch = is_numeric($request->input('search'));
                    $query->when($numericSearch, function ($query) use ($request) {
                        $query->orWhere('id', $request->input('search'));
                    }, function ($query) use ($request) {
                        $query->orWhere('generic_name', 'like', '%' . $request->input('search') . '%')
                            ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');

                        // Add condition to search by category name
                        $query->orWhereHas('category', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('search') . '%');
                        });
                    });
                });
            })
            ->where('stocks', '>', 0)
            ->where('expiration_date', '>=', $currentDate)
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.medicines.index', compact('categories', 'medicines', 'query', 'column', 'order', 'entries'));
    }
    public function create()
    {
        $categories = Category::all();

        return view('medicines.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'generic_name' => 'required|string',
            'brand_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stocks' => 'required|integer',
            'expiration_date' => 'required|date|after_or_equal:tomorrow', // Ensure expiration_date is not before tomorrow
        ]);

        $request->merge(['created_by' => auth()->id()]);
        $medicine = Medicine::create($request->all());

        // Check if the medicine is already expired
        if ($medicine->expiration_date < now()->toDateString()) {
            // If expired, set stocks to 0
            $medicine->update(['stocks' => 0]);
        } else {
            // If not expired, proceed with normal stocks
            $medicine->update(['stocks' => $request->input('stocks')]);
        }

        return redirect()->route('medicines.index')->with('success', 'Medicine created successfully');
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::all();

        return view('medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'generic_name' => 'required|string',
            'brand_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stocks' => 'required|integer',
            'expiration_date' => 'required|date',
        ]);
        $request->merge(['updated_by' => auth()->id()]);
        $medicine->update($request->all());

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully');
    }

    public function outOfStock(Request $request)
    {
        $query = $request->input('search', ''); // Default to an empty string if not provided
        $entries = $request->input('entries', 10); // Default to 10 if not provided
        $column = $request->input('column', 'id'); // Default to 'id' if not provided
        $order = $request->input('order', 'asc'); // Default to 'asc' if not provided

        $outOfStockMedicines = Medicine::where('stocks', 0)
            ->where('expiration_date', '>=', now()) // Exclude expired medicines
            ->when($query, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $numericSearch = is_numeric($request->input('search'));
                    $query->when($numericSearch, function ($query) use ($request) {
                        $query->orWhere('id', $request->input('search'));
                    }, function ($query) use ($request) {
                        $query->orWhere('generic_name', 'like', '%' . $request->input('search') . '%')
                            ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');

                        // Add condition to search by category name
                        $query->orWhereHas('category', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('search') . '%');
                        });
                    });
                });
            })
            ->orderBy($column, $order)
            ->paginate($entries); // Use the $entries variable for pagination

        return view('admin.medicines.out-of-stock', compact('outOfStockMedicines', 'query', 'entries', 'column', 'order'))
            ->with('success', 'Out of stock medicines retrieved successfully');
    }

    public function editOutOfStock(Medicine $medicine)
    {
        $categories = Category::all();

        return view('admin.medicines.edit-out-of-stock', compact('medicine', 'categories'));
    }

    public function updateOutOfStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'stocks' => 'required|integer',
        ]);

        $medicine->update($request->all());

        // Redirect back to the out-of-stock medicines list
        return redirect()->route('medicines.out-of-stock')->with('success', 'Stock updated successfully');
    }

    public function expired(Request $request)
    {
        $query = $request->input('search', '');
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        $expiredMedicines = Medicine::where('expiration_date', '<', now())
            ->when($query, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $numericSearch = is_numeric($request->input('search'));
                    $query->when($numericSearch, function ($query) use ($request) {
                        $query->orWhere('id', $request->input('search'));
                    }, function ($query) use ($request) {
                        $query->orWhere('generic_name', 'like', '%' . $request->input('search') . '%')
                            ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');

                        // Add condition to search by category name
                        $query->orWhereHas('category', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->input('search') . '%');
                        });
                    });
                });
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.medicines.expired', compact('expiredMedicines', 'query', 'entries', 'column', 'order'))
            ->with('success', 'Expired medicines retrieved successfully');
    }
    public function deleteExpired(Request $request)
    {
        $expiredMedicine = Medicine::where('expiration_date', '<', now())->first();

        if ($expiredMedicine) {
            $expiredMedicine->delete();
            return redirect()->route('medicines.expired')->with('success', 'Expired medicine deleted successfully');
        }

        return redirect()->route('medicines.expired')->with('error', 'No expired medicines found to delete');
    }

    public function generateMedicineReport(Request $request)
    {
        // If the request is GET, show the form
        if ($request->isMethod('get')) {
            return view('admin.medicines.generate_medicine_report');
        }

        // If the request is POST, handle the form submission

        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // Get data for the report within the date range
        $reportData = Medicine::with('category')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($request->input('exportFormat') === 'pdf') {
            $pdfFileName = 'medicine_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('admin.medicines.medicine-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        }

        // Export to Excel
        if ($request->input('exportFormat') === 'excel') {
            $excelFileName = 'medicine_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new MedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Medicine report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }

    public function generateOutOfStockReport(Request $request)
    {
        // If the request is GET, show the form
        if ($request->isMethod('get')) {
            return view('admin.medicines.generate_out_of_stock_report');
        }

        // If the request is POST, handle the form submission

        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // Get data for the out-of-stock report within the date range
        $reportData = Medicine::where('stocks', 0)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No out-of-stock data available for the selected date range');
        }

        // Export to PDF
        if ($request->input('exportFormat') === 'pdf') {
            $pdfFileName = 'out_of_stock_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('admin.medicines.out-of-stock-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        }

        // Export to Excel
        if ($request->input('exportFormat') === 'excel') {
            $excelFileName = 'out_of_stock_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new MedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Out-of-stock report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }

    public function generateExpiredReport(Request $request)
    {
        // If the request is GET, show the form
        if ($request->isMethod('get')) {
            return view('admin.medicines.generate_expired_report');
        }

        // If the request is POST, handle the form submission

        $fromDate = $request->input('from');
        $toDate = $request->input('to');

        // Validate the input
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'exportFormat' => 'required|in:pdf,excel',
        ]);

        // Get data for the expired report within the date range
        $reportData = Medicine::where('expiration_date', '<', now())
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No expired data available for the selected date range');
        }

        // Export to PDF
        if ($request->input('exportFormat') === 'pdf') {
            $pdfFileName = 'expired_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = PDF::loadView('admin.medicines.expired-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        }

        // Export to Excel
        if ($request->input('exportFormat') === 'excel') {
            $excelFileName = 'expired_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new MedicineReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Expired report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
