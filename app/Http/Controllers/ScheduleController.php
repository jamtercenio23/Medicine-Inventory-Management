<?php

namespace App\Http\Controllers;

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

        $schedules = Schedule::with('barangay')
            ->when($query, function ($query) use ($request) {
                $query->whereHas('barangay', function ($subquery) use ($request) {
                    $subquery->where('name', 'like', '%' . $request->input('search') . '%');
                });
            })
            ->paginate($request->input('entries', 10));

        return view('admin.schedules.index', compact('schedules', 'barangays', 'medicines', 'query'));
    }


    public function create()
    {
        $barangays = Barangay::all();
        $medicines = Medicine::all();

        return view('schedules.create', compact('barangays', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'medicine_id' => 'required|exists:medicines,id',
            'stock' => 'required|integer',
            'schedule_date_time' => 'required|date',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully');
    }

    public function edit(Schedule $schedule)
    {
        $barangays = Barangay::all();
        $medicines = Medicine::all();

        return view('schedules.edit', compact('schedule', 'barangays', 'medicines'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'barangay_id' => 'required|exists:barangays,id',
            'medicine_id' => 'required|exists:medicines,id',
            'stock' => 'required|integer',
            'schedule_datetime' => 'required|date',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }
}
