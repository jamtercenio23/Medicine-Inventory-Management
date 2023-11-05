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

        if ($user->isAdmin()) {
            $barangayMedicines = BarangayMedicine::query();
        } else {
            $barangayMedicines = BarangayMedicine::where('barangay_id', $user->barangay_id);
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
