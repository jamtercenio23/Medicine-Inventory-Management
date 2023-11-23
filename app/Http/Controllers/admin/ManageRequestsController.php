<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangayMedicine;

class ManageRequestsController extends Controller
{
    public function index(Request $request)
    {
        $restockRequests = BarangayMedicine::all();
        $query = $request->input('search');
        $restockRequests = BarangayMedicine::when($query, function ($query) use ($request) {
            $query->where('generic_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('status', 'like', '%' . $request->input('search') . '%');
        })->paginate($request->input('entries', 10));
        return view('admin.manage-requests.index', compact('restockRequests', 'query'));
    }

    public function approveReject(Request $request, BarangayMedicine $barangayMedicine)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_comment' => 'nullable|string',
        ]);

        // Update the status and admin comment
        $barangayMedicine->update([
            'status' => $request->input('status'),
            'admin_comment' => $request->input('admin_comment'),
        ]);

        // Remove the session variable to indicate that the medicine can be requested again
        session()->forget("requested_medicine_{$barangayMedicine->id}");

        return redirect()->route('admin.manage-requests')->with('success', 'Restock request updated successfully');

    }
}
