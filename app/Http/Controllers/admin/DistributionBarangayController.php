<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistributionBarangay;
use App\Models\Barangay;
use App\Models\Medicine;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DistributionBarangayController extends Controller
{
    public function index(Request $request)
    {
        $distributions = DistributionBarangay::with(['barangay', 'medicine']);

        $query = $request->input('search');

        if ($query) {
            $distributions->whereHas('barangay', function ($subquery) use ($query) {
                $subquery->where('name', 'like', '%' . $query . '%');
            });
        }

        $distributions = $distributions->paginate($request->input('entries', 10));

        $barangays = Barangay::all();
        $medicines = Medicine::all();

        return view('admin.distribution-barangay.index', compact('distributions', 'barangays', 'medicines', 'query'));
    }

    public function create()
    {
        $barangays = Barangay::all();
        $medicines = Medicine::where('stocks', '>', 0)->where('expiration_date', '>=', now()->toDateString())->get();

        return view('admin.distribution-barangay.create_modal', compact('barangays', 'medicines'));
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
                'distribution_date' => 'required|date', // Changed 'checkup_date' to 'distribution_date'
            ]);

            // Create DistributionBarangay
            $distribution = DistributionBarangay::create($request->all());

            // Update Medicine stock
            $this->updateMedicineStock($distribution, 'decrement');

            return redirect()->route('distribution-barangay.index')
                ->with('success', 'Distribution created successfully');
        } catch (\Exception $e) {
            return redirect()->route('distribution-barangay.index')
                ->with('error', 'Error creating distribution: ' . $e->getMessage());
        }
    }

    public function update(Request $request, DistributionBarangay $distribution)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'medicine_id' => 'required|exists:medicines,id',
            'stocks' => 'required|integer',
            'distribution_date' => 'required|date',
        ]);

        // Update DistributionBarangay
        $distribution->update($request->all());

        // Update Medicine stock
        $this->updateMedicineStock($distribution, 'decrement');
        $this->updateMedicineStock($distribution, 'increment');

        return redirect()->route('distribution-barangay.index')->with('success', 'Distribution to barangay updated successfully');
    }

    public function destroy(DistributionBarangay $distribution)
    {
        $this->updateMedicineStock($distribution, 'increment');

        $distribution->delete();

        return redirect()->route('distribution-barangay.index')->with('success', 'Barangay Distribution deleted successfully');
    }

    private function updateMedicineStock(DistributionBarangay $distribution, $operation)
    {
        $medicine = $distribution->medicine;

        if ($medicine) {
            // Perform increment or decrement based on the operation
            if ($operation === 'increment') {
                $medicine->increment('stocks', $distribution->stocks);
            } elseif ($operation === 'decrement') {
                $medicine->decrement('stocks', $distribution->stocks);
            }
        }
    }
}
