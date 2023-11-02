<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Category;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = now()->toDateString();
        $categories = Category::all();
        $query = $request->input('search');

        $medicines = Medicine::with('category')
            ->when($query, function ($query) use ($request) {
                $query->where('generic_name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');
            })
            ->where('stocks', '>', 0)
            ->where('expiration_date', '>=', $currentDate)
            ->paginate($request->input('entries', 10));

        return view('admin.medicines.index', compact('categories', 'medicines', 'query'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('medicines.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'generic_name' => 'required|string',
        'brand_name' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'stocks' => 'required|integer',
        'expiration_date' => 'required|date|after_or_equal:tomorrow', // Ensure expiration_date is not before tomorrow
    ]);

    $medicine = Medicine::create($request->all());

    // Check if the medicine is already expired
    if ($medicine->expiration_date < now()->toDateString()) {
        // If expired, set stocks to 0
        $medicine->update(['stocks' => 0]);
    } else {
        // If not expired, proceed with normal stocks
        $medicine->update(['stocks' => $request->input('stocks')]);
    }

    return redirect()->route('medicines.index')->with('success', 'Medicine created successfully');
}

    public function edit(Medicine $medicine)
    {
        $categories = Category::all();

        return view('medicines.edit', compact('medicine', 'categories'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'generic_name' => 'required|string',
            'brand_name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stocks' => 'required|integer',
            'expiration_date' => 'required|date',
        ]);

        $medicine->update($request->all());

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully');
    }

    public function outOfStock(Request $request)
{
    $query = $request->input('search', ''); // Default to an empty string if not provided
    $outOfStockMedicines = Medicine::where('stocks', 0)
        ->where('expiration_date', '>=', now()) // Exclude expired medicines
        ->when($query, function ($query) use ($request) {
            $query->where('generic_name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('brand_name', 'like', '%' . $request->input('search') . '%');
        })
        ->paginate(10); // You can adjust the pagination size as needed

    return view('admin.medicines.out-of-stock', compact('outOfStockMedicines', 'query'))
        ->with('success', 'Out of stock medicines retrieved successfully');
}

    public function editOutOfStock(Medicine $medicine)
    {
        $categories = Category::all();

        return view('admin.medicines.edit-out-of-stock', compact('medicine', 'categories'));
    }

    public function updateOutOfStock(Request $request, Medicine $medicine)
    {
        $request->validate([
            'stocks' => 'required|integer',
        ]);

        $medicine->update($request->all());

        // Redirect back to the out-of-stock medicines list
        return redirect()->route('medicines.out-of-stock')->with('success', 'Stock updated successfully');
    }

    public function expired(Request $request)
{
    $query = $request->input('search', '');
    $expiredMedicines = Medicine::where('expiration_date', '<', now())->paginate(10);

    return view('admin.medicines.expired', compact('expiredMedicines', 'query'))
        ->with('success', 'Expired medicines retrieved successfully');
}

public function deleteExpired(Request $request)
{
    $expiredMedicine = Medicine::where('expiration_date', '<', now())->first();

    if ($expiredMedicine) {
        $expiredMedicine->delete();
        return redirect()->route('medicines.expired')->with('success', 'Expired medicine deleted successfully');
    }

    return redirect()->route('medicines.expired')->with('error', 'No expired medicines found to delete');
}
}
