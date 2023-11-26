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
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $entries = $request->input('entries', 10);

        $restockRequests = BarangayMedicine::when($query, function ($query) use ($request) {
            $numericSearch = is_numeric($request->input('search'));
            $query->when($numericSearch, function ($query) use ($request) {
                $query->orWhere('id', $request->input('search'));
            }, function ($query) use ($request) {
                $query->orWhere('generic_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('status', 'like', '%' . $request->input('search') . '%');

                $query->orWhereHas('barangay', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->input('search') . '%');
                });
            });
        })
            ->where('stocks', 0)
            ->orderBy($column, $order)
            ->paginate(intval($entries));

        return view('admin.manage-requests.index', compact('restockRequests', 'query', 'column', 'order', 'entries'));
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
