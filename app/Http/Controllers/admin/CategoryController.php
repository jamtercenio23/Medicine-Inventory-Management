<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $categories = Category::when($query, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        })->paginate($request->input('entries', 10));

        return view('admin.categories.index', compact('categories', 'query'));
    }


    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        // Set the created_by field to the authenticated user's ID
        $request->merge(['created_by' => auth()->id()]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
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
    }
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
