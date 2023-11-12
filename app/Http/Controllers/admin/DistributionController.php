<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Distribution;
use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\DistributionReportExport;
use Illuminate\Support\Facades\Response;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $distributions = Distribution::with(['patient', 'medicine']);

        $query = $request->input('search');

        if ($query) {
            $distributions->whereHas('patient', function ($subquery) use ($query) {
                $subquery->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%');
            });
        }

        $distributions = $distributions->paginate($request->input('entries', 10));

        $patients = Patient::all();
        $medicines = Medicine::all();

        return view('admin.distributions.index', compact('distributions', 'patients', 'medicines', 'query'));
    }

    public function create()
    {
        $patients = Patient::all();
        $medicines = Medicine::where('stocks', '>', 0)->where('expiration_date', '>=', now()->toDateString())->get();

        return view('distributions.create', compact('patients', 'medicines'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:patients,id',
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
                'checkup_date' => 'required|date',
                'diagnose' => 'required|string',
            ]);

            // Create Distribution
            $distribution = Distribution::create($request->all());

            // Update Medicine stock
            $this->updateMedicineStock($distribution, 'decrement', $request->input('stocks'));

            return redirect()->route('distributions.index')
                ->with('success', 'Distribution created successfully');
        } catch (\Exception $e) {
            return redirect()->route('distributions.index')
                ->with('error', 'Error creating distribution: ' . $e->getMessage());
        }
    }


    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicine_id' => 'required|exists:medicines,id',
            'stocks' => 'required|integer',
            'checkup_date' => 'required|date',
            'diagnose' => 'required|string',
        ]);

        // Get the original distribution data
        $originalDistribution = $distribution->fresh();

        // Update Distribution
        $distribution->update($request->all());

        // Calculate the stock change
        $stockChange = $request->input('stocks') - $originalDistribution->stocks;

        // Update Medicine stock
        if ($stockChange != 0) {
            if ($stockChange > 0) {
                // Increase stock in inventory
                $this->updateMedicineStock($distribution, 'decrement', abs($stockChange));
            } else {
                // Decrease stock in inventory
                $this->updateMedicineStock($distribution, 'increment', abs($stockChange));
            }
        }

        return redirect()->route('distributions.index')->with('success', 'Distribution updated successfully');
    }

    public function destroy(Distribution $distribution)
    {
        // Get the quantity of stocks in the distribution
        $quantity = $distribution->stocks;

        // Update Medicine stock before deleting distribution
        $this->updateMedicineStock($distribution, 'increment', $quantity);

        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Distribution deleted successfully');
    }


    // Helper method to update Medicine stock
    private function updateMedicineStock(Distribution $distribution, $operation, $quantity = 1)
    {
        $medicine = $distribution->medicine;

        // Perform increment or decrement based on the operation
        if ($operation === 'increment') {
            $medicine->increment('stocks', $quantity);
        } elseif ($operation === 'decrement') {
            $medicine->decrement('stocks', $quantity);
        }
    }

    public function generateDistributionReport(Request $request)
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

        // Get data for the distribution report within the date range
        $reportData = Distribution::with(['patient', 'medicine'])
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No distribution data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'distribution_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = Pdf::loadView('admin.distributions.distribution-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'distribution_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new DistributionReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Distribution report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
