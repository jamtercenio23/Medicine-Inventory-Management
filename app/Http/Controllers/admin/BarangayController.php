<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use Illuminate\Support\Facades\Log;

class BarangayController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $entries = $request->input('entries', 10);

        $barangays = Barangay::when($query, function ($query) use ($request) {
            $numericSearch = is_numeric($request->input('search'));
            $query->when($numericSearch, function ($query) use ($request) {
                $query->orWhere('id', $request->input('search'));
            }, function ($query) use ($request) {
                $query->orWhere('name', 'like', '%' . $request->input('search') . '%');
            });
        })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.barangays.index', compact('barangays', 'query', 'column', 'order', 'entries'));
    }
    public function create()
    {
        return view('barangays.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:barangays',
            ]);

            $request->merge(['created_by' => auth()->id()]);

            Barangay::create($request->all());

            return redirect()->route('barangays.index')->with('success', 'Barangay created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating Barangay: ' . $e->getMessage());
            return redirect()->route('barangays.index')->with('error', 'An error occurred while creating the Barangay. Please try again.');
        }
    }


    public function edit(Barangay $barangay)
    {
        return view('barangays.edit', compact('barangay'));
    }

    public function update(Request $request, Barangay $barangay)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:barangays,name,' . $barangay->id,
            ]);

            $request->merge(['updated_by' => auth()->id()]);

            $barangay->update($request->all());

            return redirect()->route('barangays.index')->with('success', 'Barangay updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating Barangay: ' . $e->getMessage());
            return redirect()->route('barangays.index')->with('error', 'An error occurred while updating the Barangay. Please try again.');
        }
    }

    public function destroy(Barangay $barangay)
    {
        $barangay->delete();

        return redirect()->route('barangays.index')->with('success', 'Barangay deleted successfully');
    }
}
