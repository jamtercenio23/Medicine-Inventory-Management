<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Barangay;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $barangays = Barangay::all();
        $query = $request->input('search');

        $patients = Patient::with('barangay')
            ->when($query, function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
            })
            ->paginate($request->input('entries', 10));

        return view('admin.patients.index', compact('patients', 'barangays', 'query'));
    }



    public function create()
    {
        $barangays = Barangay::all();

        return view('patients.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'barangay_id' => 'required|exists:barangays,id',
            'diagnose' => 'required|string',
        ]);

        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient created successfully');
    }

    public function edit(Patient $patient)
    {
        $barangays = Barangay::all();

        return view('patients.edit', compact('patient', 'barangays'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'barangay_id' => 'required|exists:barangays,id',
            'diagnose' => 'required|string',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }
}
