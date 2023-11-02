<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;

class BarangayController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $barangays = Barangay::when($query, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })->paginate($request->input('entries', 10));
        return view('admin.barangays.index', compact('barangays', 'query'));
    }

    public function create()
    {
        return view('barangays.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:barangays',
        ]);

        Barangay::create($request->all());

        return redirect()->route('barangays.index')->with('success', 'Barangay created successfully');
    }

    public function edit(Barangay $barangay)
    {
        return view('barangays.edit', compact('barangay'));
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate([
            'name' => 'required|string|unique:barangays,name,' . $barangay->id,
        ]);

        $barangay->update($request->all());

        return redirect()->route('barangays.index')->with('success', 'Barangay updated successfully');
    }

    public function destroy(Barangay $barangay)
    {
        $barangay->delete();

        return redirect()->route('barangays.index')->with('success', 'Barangay deleted successfully');
    }

}
