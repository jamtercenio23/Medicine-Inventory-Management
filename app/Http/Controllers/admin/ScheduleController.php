<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Medicine;
use App\Models\Barangay;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::with(['barangay', 'medicine'])->get();
        $barangays = Barangay::all();
        $medicines = Medicine::all();
        $query = $request->input('search');
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $entries = $request->input('entries', 10);

        $schedules = Schedule::when($query, function ($query) use ($request) {
            $numericSearch = is_numeric($request->input('search'));
            $query->when($numericSearch, function ($query) use ($request) {
                $query->orWhere('id', $request->input('search'));
            }, function ($query) use ($request) {
                $query->orWhereHas('barangay', function ($query) use ($request) {
                    $query->where('name', '=', $request->input('search'));
                });
                $query->orWhereHas('medicine', function ($query) use ($request) {
                    $query->where('generic_name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');
                });
            });
        })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.schedules.index', compact('schedules', 'barangays', 'medicines', 'query', 'column', 'order', 'entries'));
    }
    public function create()
    {
        $barangays = Barangay::all();

        $medicines = Medicine::where('expiration_date', '>=', now()->toDateString())
            ->where('stocks', '>', 0)
            ->get();

        return view('schedules.create', compact('barangays', 'medicines'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'barangay_id' => 'required|exists:barangays,id',
                'medicine_id' => 'required|exists:medicines,id',
                'stock' => 'required|integer',
                'schedule_date_time' => 'required|date',
            ]);

            Schedule::create($request->all());

            return redirect()->route('schedules.index')->with('success', 'Schedule created successfully');
        } catch (\Exception $e) {
            return redirect()->route('schedules.index')->with('error', 'An error occurred while creating the schedule: ' . $e->getMessage());
        }
    }
    public function edit(Schedule $schedule)
    {
        $barangays = Barangay::all();
        $medicines = Medicine::all();

        return view('schedules.edit', compact('schedule', 'barangays', 'medicines'));
    }
    public function update(Request $request, Schedule $schedule)
    {
        try {
            $request->validate([
                'barangay_id' => 'required|exists:barangays,id',
                'medicine_id' => 'required|exists:medicines,id',
                'stock' => 'required|integer',
                'schedule_date_time' => 'required|date',
            ]);

            $schedule->update([
                'barangay_id' => $request->input('barangay_id'),
                'medicine_id' => $request->input('medicine_id'),
                'stock' => $request->input('stock'),
                'schedule_datetime' => $request->input('schedule_date_time'),
            ]);

            return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('schedules.index')->with('error', 'An error occurred while updating the schedule: ' . $e->getMessage());
        }
    }
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }
}
