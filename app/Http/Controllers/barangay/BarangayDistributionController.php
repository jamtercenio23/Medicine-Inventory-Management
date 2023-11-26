<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\BarangayDistribution;
use App\Models\BarangayPatient;
use App\Models\BarangayMedicine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\BarangayDistributionReportExport;
use Illuminate\Support\Facades\Response;

class BarangayDistributionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $user = Auth::user();
        $entries = $request->input('entries', 10);
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');

        if ($user->isBarangayUser()) {
            $barangayDistributions = BarangayDistribution::where('barangay_id', $user->barangay_id);

            if ($user->isBHW()) {
                $barangayDistributions->orWhere(function ($query) use ($user) {
                    $query->where('bhw_id', $user->id)
                        ->where('barangay_id', $user->barangay_id);
                });
            }
        } else {
            $barangayDistributions = BarangayDistribution::query();
        }

        $barangayDistributions = $barangayDistributions
            ->with(['barangayPatient', 'barangayMedicine'])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('barangayPatient', function ($subquery) use ($query) {
                    $subquery->where('first_name', 'like', '%' . $query . '%')
                        ->orWhere('last_name', 'like', '%' . $query . '%');
                });
            })
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                $query->where('barangay_distributions.barangay_id', $user->barangay_id);
            })
            ->when($column === 'first_name', function ($query) use ($order) {
                // If ordering by 'first_name', join the 'barangayPatient' table
                $query->join('barangay_patients', 'barangay_distributions.barangay_patient_id', '=', 'barangay_patients.id')
                    ->orderBy('barangay_patients.first_name', $order);
            })
            ->orderBy($column, $order)
            ->paginate($entries);

        // Loop through the results and handle null values
        $barangayDistributions->each(function ($distribution) {
            $distribution->barangayPatient; // Access the relationship to trigger loading

            // Check if the relationship is not null before accessing its properties
            if ($distribution->barangayPatient) {
                $distribution->patient_first_name = $distribution->barangayPatient->first_name;
                // Add other properties as needed
            } else {
                $distribution->patient_first_name = null; // or set a default value
            }
        });

        // Define $barangayPatients and $barangayMedicines
        $barangayPatients = BarangayPatient::all();
        $barangayMedicines = BarangayMedicine::where('expiration_date', '>=', now()->toDateString())
            ->where('barangay_id', $user->barangay_id)
            ->get();

        return view('barangay.barangay_distributions.index', compact('barangayDistributions', 'barangayPatients', 'barangayMedicines', 'query', 'entries', 'column', 'order'));
    }
    public function create()
    {
        $user = auth()->user();

        // Check if the user has at least one role
        if ($user->getRoleNames()->isEmpty()) {
            return redirect()->route('barangay-distributions.index')->with('error', 'User does not have any roles');
        }

        // Retrieve the first role from the collection
        $firstRole = $user->getRoleNames()->first();

        // Check if the user is a barangay user or admin
        if ($firstRole === 'barangay' || $firstRole === 'admin') {
            // Fetch patients and medicines related to the user's barangay
            $barangayPatients = BarangayPatient::where('barangay_id', $user->barangay_id)->get();
            $barangayMedicines = BarangayMedicine::where('stocks', '>', 0)
                ->where('expiration_date', '>=', now()->toDateString())
                ->where('barangay_id', $user->barangay_id)
                ->get();

            return view('barangay.barangay_distributions.create', compact('barangayPatients', 'barangayMedicines'));
        } else {
            // User is not authorized
            return redirect()->route('barangay-distributions.index')->with('error', 'Unauthorized to create distribution');
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            // Check if the user is a BHW or admin
            if ($user->isBHW() || $user->isAdmin()) {
                // Associate with the user's barangay_id if it's a BHW user
                $barangayId = $user->isBHW() ? $user->barangay_id : null;

                // Get the selected medicine
                $selectedMedicine = BarangayMedicine::find($request->input('medicine_id'));

                // Check if the selected medicine exists and has sufficient stocks
                if (!$selectedMedicine || $selectedMedicine->stocks < $request->input('stocks')) {
                    return redirect()->route('barangay-distributions.create')->with('error', 'Invalid medicine or insufficient stocks');
                }

                // Create BarangayDistribution
                $barangayDistribution = new BarangayDistribution([
                    'barangay_patient_id' => $request->input('barangay_patient_id'),
                    'barangay_medicine_id' => $request->input('medicine_id'),
                    'stocks' => $request->input('stocks'),
                    'checkup_date' => $request->input('checkup_date'),
                    'diagnose' => $request->input('diagnose'),
                    'bhw_id' => $user->isBHW() ? $user->id : null,
                    'barangay_id' => $barangayId,
                ]);

                // Save the distribution
                $barangayDistribution->save();

                // Update BarangayMedicine stock
                $this->updateBarangayMedicineStock($barangayDistribution, 'decrement', $request->input('stocks'));

                return redirect()->route('barangay-distributions.index')->with('success', 'Distribution created successfully');
            } else {
                return redirect()->route('barangay-distributions.index')->with('error', 'Unauthorized to create distribution');
            }
        } catch (\Exception $e) {
            return redirect()->route('barangay-distributions.index')->with('error', 'Failed to create distribution: ' . $e->getMessage());
        }
    }
    public function update(Request $request, BarangayDistribution $barangayDistribution)
    {
        $request->validate([
            'patient_id' => 'required|exists:barangay_patients,id',
            'medicine_id' => 'required|exists:barangay_medicines,id',
            'stocks' => 'required|integer',
            'checkup_date' => 'required|date',
            'diagnose' => 'required|string',
        ]);

        try {
            // Get the original barangay distribution data
            $originalBarangayDistribution = $barangayDistribution->fresh();

            // Update BarangayDistribution
            $barangayDistribution->update([
                'barangay_patient_id' => $request->input('patient_id'),
                'barangay_medicine_id' => $request->input('medicine_id'),
                'stocks' => $request->input('stocks'),
                'checkup_date' => $request->input('checkup_date'),
                'diagnose' => $request->input('diagnose'),
            ]);

            // Calculate the stock change
            $stockChange = $request->input('stocks') - $originalBarangayDistribution->stocks;

            // Update BarangayMedicine stock
            if ($stockChange != 0) {
                if ($stockChange > 0) {
                    // Increase stock in inventory
                    $this->updateBarangayMedicineStock($barangayDistribution, 'decrement', abs($stockChange));
                } else {
                    // Decrease stock in inventory
                    $this->updateBarangayMedicineStock($barangayDistribution, 'increment', abs($stockChange));
                }
            }

            return redirect()->route('barangay-distributions.index')->with('success', 'Distribution updated successfully');
        } catch (\Exception $e) {
            // Handle the exception, you might want to log it or return an error message
            return redirect()->route('barangay-distributions.index')->with('error', 'Failed to update distribution');
        }
    }

    public function destroy(BarangayDistribution $barangayDistribution)
    {
        // Get the quantity of stocks in the distribution
        $quantity = $barangayDistribution->stocks;

        // Update BarangayMedicine stock before deleting distribution
        $this->updateBarangayMedicineStock($barangayDistribution, 'increment', $quantity);

        $barangayDistribution->delete();

        return redirect()->route('barangay-distributions.index')->with('success', 'Distribution deleted successfully');
    }

    private function updateBarangayMedicineStock(BarangayDistribution $barangayDistribution, $operation, $quantity = 1)
    {
        $barangayMedicine = $barangayDistribution->barangayMedicine;

        // Perform increment or decrement based on the operation
        if ($operation === 'increment') {
            $barangayMedicine->increment('stocks', $quantity);
        } elseif ($operation === 'decrement') {
            $barangayMedicine->decrement('stocks', $quantity);
        }
    }
    public function generateBarangayDistributionReport(Request $request)
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

        // Get data for the barangay distribution report within the date range
        $reportData = BarangayDistribution::with(['barangayPatient', 'barangayMedicine'])
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->when($user->isBarangayUser() && $user->isBHW(), function ($query) use ($user) {
                // For BHW users, include only distributions created by the same BHW in the same barangay
                $query->where('bhw_id', $user->id)
                    ->where('barangay_id', $user->barangay_id);
            })
            ->when($user->isBarangayUser() && !$user->isBHW(), function ($query) use ($user) {
                // Limit Barangay users to their own barangay
                $query->where('barangay_id', $user->barangay_id);
            })
            ->get();

        // Check if there is data for the report
        if ($reportData->isEmpty()) {
            return redirect()->back()->with('error', 'No barangay distribution data available for the selected date range');
        }

        // Export to PDF or Excel based on the selected format
        if ($exportFormat === 'pdf') {
            $pdfFileName = 'barangay_distribution_report_' . now()->format('YmdHis') . '.pdf';
            $pdfPath = public_path('reports') . '/' . $pdfFileName;

            // Generate and save the PDF file
            $pdf = Pdf::loadView('barangay.barangay_distributions.barangay-distribution-report-pdf', compact('reportData', 'fromDate', 'toDate'));
            $pdf->setPaper('a4', 'landscape');
            $pdf->save($pdfPath);

            // Download the PDF file
            return response()->download($pdfPath, $pdfFileName);
        } elseif ($exportFormat === 'excel') {
            $excelFileName = 'barangay_distribution_report_' . now()->format('YmdHis') . '.xlsx';

            // Generate the Excel file and return it as a download
            return (new BarangayDistributionReportExport($reportData, $fromDate, $toDate))->download($excelFileName);
        }

        return redirect()->back()
            ->with('success', 'Barangay distribution report generated successfully')
            ->with('pdfFileName', $pdfFileName ?? null)
            ->with('excelFileName', $excelFileName ?? null);
    }
}
