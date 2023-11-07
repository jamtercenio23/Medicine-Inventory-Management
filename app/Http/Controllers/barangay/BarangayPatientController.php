<?php

namespace App\Http\Controllers\barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\BarangayPatient;
use Illuminate\Support\Facades\Auth;

class BarangayPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $user = Auth::user();

        if ($user && $user->isBHW()) {
            // If the user is a BHW, retrieve patients from their barangay
            $barangayPatients = BarangayPatient::where('barangay_id', $user->barangay_id);
        } elseif ($user && $user->isAdmin()) {
            // If the user is an Admin, retrieve patients from all barangays
            $barangayPatients = BarangayPatient::query();
        } else {
            // For all other users or unauthenticated users, don't allow access to patient data
            abort(403, 'Unauthorized');
        }

        $barangays = Barangay::all();

        $barangayPatients = $barangayPatients
            ->when($query, function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
            })
            ->paginate($request->input('entries', 10));

        return view('barangay.barangay_patients.index', compact('barangayPatients', 'barangays', 'query'));
    }

    public function create()
    {
        $user = Auth::user();
        $barangays = ($user && $user->isAdmin()) ? Barangay::all() : [$user->barangay];

        return view('barangay.barangay_patients.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female',
        ]);

        $user = Auth::user();

        if ($user->isBHW()) {
            // If the user is a BHW, set the patient's barangay to the BHW's barangay
            $request['barangay_id'] = $user->barangay_id;
        }

        BarangayPatient::create($request->all());

        return redirect()->route('barangay-patients.index')->with('success', 'Patient created successfully');
    }
    public function edit($id)
    {
        $barangayPatient = BarangayPatient::findOrFail($id);
        $barangays = Barangay::all();

        return view('barangay.barangay_patients.edit', compact('barangayPatient', 'barangays'));
    }

    public function update(Request $request, BarangayPatient $barangayPatient)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female',
        ]);

        $barangayPatient->update($request->all());

        return redirect()->route('barangay-patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy(BarangayPatient $barangayPatient)
    {
        $barangayPatient->delete();

        return redirect()->route('barangay-patients.index')->with('success', 'Patient deleted successfully');
    }
}
