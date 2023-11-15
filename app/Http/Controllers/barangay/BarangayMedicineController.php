<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangayMedicine;
use Illuminate\Support\Facades\Auth;

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
}
