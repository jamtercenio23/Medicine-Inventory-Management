<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BarangayMedicine;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\DistributionBarangay;
use App\Models\Medicine;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DistributionBarangayReportExport;
use Illuminate\Support\Facades\Response;
class DistributionBarangayController extends Controller
{
    public function index(Request $request)
    {
        $distribution_barangays = DistributionBarangay::with(['barangay', 'medicine']);

        $query = $request->input('search');

        if ($query) {
            $distribution_barangays->whereHas('barangay', function ($subquery) use ($query) {
                $subquery->where('name', 'like', '%' . $query . '%');
            });
        }

        $distribution_barangays = $distribution_barangays->paginate($request->input('entries', 10));

        $barangays = Barangay::all();
        $medicines = Medicine::all();

        return view('admin.distribution_barangay.index', compact('distribution_barangays', 'barangays', 'medicines', 'query'));
    }

    public function create()
    {
        $barangays = Barangay::all();
        $medicines = Medicine::where('stocks', '>', 0)->where('expiration_date', '>=', now()->toDateString())->get();

        return view('distribution_barangay.create', compact('barangays', 'medicines'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'barangay_id' => 'required|exists:barangays,id',
                'medicine_id' => [
                    'required',
                    'exists:medicines,id',
                    Rule::exists('medicines', 'id')->where(function ($query) {
                        // Check if medicine is not expired
                        $query->where('expiration_date', '>=', now()->toDateString());
                    }),
                ],
                'stocks' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) use ($request) {
                        // Additional check for stocks not exceeding available stocks
                        $availableStocks = Medicine::find($request->input('medicine_id'))->stocks;
                        if ($value > $availableStocks) {
                            $fail("The selected medicine does not have enough stocks.");
                        }
                    },
                ],
                'distribution_date' => 'required|date',
            ]);

            // Create Distribution
            $distribution_barangays = DistributionBarangay::create($request->all());

            // Update Medicine stock
            $this->updateMedicineStock($distribution_barangays, 'decrement', $request->input('stocks'));

            // Insert medicines into the barangay_medicines table
            BarangayMedicine::create([
                'barangay_id' => $request->input('barangay_id'),
                'medicine_id' => $request->input('medicine_id'),
                'generic_name' => $distribution_barangays->medicine->generic_name,
                'brand_name' => $distribution_barangays->medicine->brand_name,
                'category' => $distribution_barangays->medicine->category,
                'price' => $distribution_barangays->medicine->price,
                'expiration_date' => $distribution_barangays->medicine->expiration_date,
                'stocks' => $request->input('stocks'),
            ]);

            return redirect()->route('distribution_barangay.index')
                ->with('success', 'Distribution created successfully');
        } catch (\Exception $e) {
            return redirect()->route('distribution_barangay.index')
                ->with('error', 'Error creating distribution: ' . $e->getMessage());
        }
    }
    public function update(Request $request, DistributionBarangay $distribution_barangay)
{
    $request->validate([
        'stocks' => 'required|integer',
        'distribution_date' => 'required|date',
    ]);

    // Get the original distribution data
    $originalDistribution = DistributionBarangay::find($distribution_barangay->id);

    if (!$originalDistribution) {
        return redirect()->route('distribution_barangay.index')->with('error', 'Distribution record not found.');
    }

    $originalStock = $originalDistribution->stocks;
    $updatedStock = $request->input('stocks');

    // Calculate the difference between the original stock and the updated stock
    $stockChange = $updatedStock - $originalStock;

    // Update Medicine stock
    if ($stockChange > 0) {
        // If stocks are increasing, we need to increment the medicine stock
        $this->updateMedicineStock($originalDistribution, 'decrement', $stockChange);
    } elseif ($stockChange < 0) {
        // If stocks are decreasing, we need to decrement the medicine stock
        $this->updateMedicineStock($originalDistribution, 'increment', abs($stockChange));
    }

    // Update Distribution with the existing 'barangay_id' and 'medicine_id'
    $distribution_barangay->update([
        'stocks' => $request->input('stocks'),
        'distribution_date' => $request->input('distribution_date'),
    ]);

    // Update 'stocks' in barangay_medicines
    BarangayMedicine::updateOrCreate(
        [
            'barangay_id' => $originalDistribution->barangay_id,
            'medicine_id' => $originalDistribution->medicine_id,
        ],
        [
            'stocks' => $request->input('stocks'),
        ]
    );

    return redirect()->route('distribution_barangay.index')->with('success', 'Distribution updated successfully');
}

    public function destroy(DistributionBarangay $distribution_barangay)
    {
        if (!$distribution_barangay) {
            return redirect()->route('distribution_barangay.index')
                ->with('error', 'Distribution record not found.');
        }

        $quantity = $distribution_barangay->stocks;

        // Update Medicine stock
        $this->updateMedicineStock($distribution_barangay, 'increment', $quantity);

        // Delete the corresponding record in barangay_medicines
        BarangayMedicine::where([
            'barangay_id' => $distribution_barangay->barangay_id,
            'medicine_id' => $distribution_barangay->medicine_id,
        ])->delete();

        // Delete the distribution entry
        $distribution_barangay->delete();

        return redirect()->route('distribution_barangay.index')
            ->with('success', 'Distribution deleted successfully');
    }

    private function updateMedicineStock(DistributionBarangay $distribution_barangays, $operation, $quantity = 1)
    {
        $medicine = $distribution_barangays->medicine;

        // Perform increment or decrement based on the operation
        if ($operation === 'increment') {
            $medicine->increment('stocks', $quantity);
        } elseif ($operation === 'decrement') {
            $medicine->decrement('stocks', $quantity);
        }
    }

    public function generateDistributionBarangayReport(Request $request)
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

        // Get data for the distribution barangay report within the date range
        $reportData = DistributionBarangay::with(['barangay', 'medicine'])
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No distribution barangay data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'distribution_barangay_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = Pdf::loadView('admin.distribution_barangay.distribution-barangay-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'distribution_barangay_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new DistributionBarangayReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Distribution barangay report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
