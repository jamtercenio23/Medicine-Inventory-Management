<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $column = $request->input('column', 'id');
        $order = $request->input('order', 'asc');
        $entries = $request->input('entries', 10);  // Add this line

        $categories = Category::when($query, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })
            ->orderBy($column, $order)
            ->paginate($entries);

        return view('admin.categories.index', compact('categories', 'query', 'column', 'order', 'entries'));
    }
    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:categories',
            ]);

            $request->merge(['created_by' => auth()->id()]);

            Category::create($request->all());

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating Category: ' . $e->getMessage());
            return redirect()->route('categories.index')->with('error', 'An error occurred while creating the Category. Please try again.');
        }
    }
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        try {
            // Make sure the user is authenticated
            if (auth()->check()) {
                $request->validate([
                    'name' => 'required|string|unique:categories,name,' . $category->id,
                ]);

                // Set the updated_by field to the authenticated user's ID
                $request->merge(['updated_by' => auth()->id()]);

                $category->update($request->all());

                return redirect()->route('categories.index')->with('success', 'Category updated successfully');
            } else {
                // Handle unauthenticated user (optional)
                return redirect()->route('login')->with('error', 'Unauthorized access');
            }
        } catch (\Exception $e) {
            Log::error('Error updating Category: ' . $e->getMessage());
            return redirect()->route('categories.index')->with('error', 'An error occurred while updating the Category. Please try again.');
        }
    }
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
