<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\DistributionBarangay;
use App\Models\Medicine;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistributionBarangayController extends Controller
{
    public function index(Request $request)
    {
        $distribution_barangays = DistributionBarangay::with(['barangay', 'medicine']);

        $query = $request->input('search');

        if ($query) {
            $distribution_barangays->whereHas('patient', function ($subquery) use ($query) {
                $subquery->where('first_name', 'like', '%' . $query . '%')
                    ->orWhere('last_name', 'like', '%' . $query . '%');
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
            'barangay_id' => 'required|exists:barangays,id',
            'medicine_id' => 'required|exists:medicines,id',
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

        // Update Distribution
        $distribution_barangay->update($request->all());

        return redirect()->route('distribution_barangay.index')->with('success', 'Distribution updated successfully');
    }

    public function destroy(DistributionBarangay $distribution_barangay)
    {
        if (!$distribution_barangay) {
            return redirect()->route('distribution_barangay.index')
                ->with('error', 'Distribution record not found.');
        }

        $quantity = $distribution_barangay->stocks;

        $this->updateMedicineStock($distribution_barangay, 'increment', $quantity);

        $distribution_barangay->delete();

        return redirect()->route('distribution_barangay.index')->with('success', 'Distribution deleted successfully');
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
}
