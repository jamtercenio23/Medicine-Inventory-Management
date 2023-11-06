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
        // Check if the user is authenticated and is a barangay user
        if (Auth::check() && Auth::user()->isBarangayUser()) {
            // Get the authenticated user's barangay
            $userBarangayId = Auth::user()->barangay_id;

            // Retrieve only the patients belonging to the authenticated user's barangay
            $barangayPatients = BarangayPatient::where('barangay_id', $userBarangayId)->get();
        } else {
            // If the user is not a barangay user or not authenticated, show all patients
            $barangayPatients = BarangayPatient::all();
        }

        $barangays = Barangay::all();
        $barangayPatients = BarangayPatient::with('barangay')
            ->when($query, function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
            })
            ->paginate($request->input('entries', 10));

        return view('barangay.barangay_patients.index', compact('barangayPatients', 'barangays', 'query'));
    }

    public function create()
    {
        $barangays = Barangay::all();

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
