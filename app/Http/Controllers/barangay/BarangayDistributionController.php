<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangayDistribution;
use App\Models\BarangayPatient;
use App\Models\BarangayMedicine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangayDistributionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $user = Auth::user();

        // Get barangay-specific distributions if the user is a barangay user
        if ($user->isBarangayUser()) {
            $barangayDistributions = BarangayDistribution::where('barangay_id', $user->barangay_id);
        } else {
            // Show all distributions for admin users
            $barangayDistributions = BarangayDistribution::query();
        }

        $barangayDistributions = $barangayDistributions->with(['patient', 'medicine'])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('patient', function ($subquery) use ($query) {
                    $subquery->where('first_name', 'like', '%' . $query . '%')
                        ->orWhere('last_name', 'like', '%' . $query . '%');
                });
            })
            ->paginate($request->input('entries', 10));

        $barangayPatients = BarangayPatient::all();
        $barangayMedicines = BarangayMedicine::where('stocks', '>', 0)
            ->where('expiration_date', '>=', now()->toDateString())
            ->get();

        return view('barangay.barangay_distributions.index', compact('barangayDistributions', 'barangayPatients', 'barangayMedicines', 'query'));
    }

    public function create()
    {
        $barangayPatients = BarangayPatient::all();
        $barangayMedicines = BarangayMedicine::where('stocks', '>', 0)
            ->where('expiration_date', '>=', now()->toDateString())
            ->get();

        return view('barangay.barangay_distributions.create', compact('barangayPatients', 'barangayMedicines'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'barangay_patient_id' => 'required|exists:barangay_patients,id',
            'barangay_medicine_id' => [
                'required',
                'exists:barangay_medicines,id',
                function ($attribute, $value, $fail) use ($request) {
                    $barangayMedicine = BarangayMedicine::find($value);

                    // Check if medicine is not expired
                    if (!$barangayMedicine || $barangayMedicine->expiration_date < now()->toDateString()) {
                        $fail('The selected medicine is expired.');
                    }
                },
            ],
            'stocks' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    $barangayMedicine = BarangayMedicine::find($request->input('barangay_medicine_id'));

                    // Check if the requested stocks are available
                    if (!$barangayMedicine || $barangayMedicine->stocks < $value) {
                        $fail('The selected medicine does not have enough stocks.');
                    }
                },
            ],
            'checkup_date' => 'required|date',
            'diagnose' => 'required|string',
        ]);

        // Create BarangayDistribution
        $barangayDistribution = BarangayDistribution::create($request->all());

        // Update BarangayMedicine stock
        $this->updateBarangayMedicineStock($barangayDistribution, 'decrement', $request->input('stocks'));

        return redirect()->route('barangay-distributions.index')->with('success', 'Distribution created successfully');
    }


    public function update(Request $request, BarangayDistribution $barangayDistribution)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'barangay_patient_id' => 'required|exists:barangay_patients,id',
            'barangay_medicine_id' => 'required|exists:barangay_medicines,id',
            'stocks' => 'required|integer',
            'checkup_date' => 'required|date',
            'diagnose' => 'required|string',
        ]);

        // Get the original barangay distribution data
        $originalBarangayDistribution = $barangayDistribution->fresh();

        // Update BarangayDistribution
        $barangayDistribution->update($request->all());

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
}
