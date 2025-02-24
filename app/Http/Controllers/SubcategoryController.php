<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['name', 'category_id', 'status']);
        $data['slug'] = Str::slug($request->name);

        SubCategory::create($data);

        return redirect()->route('subcategories.index')->with('success', 'Danh mục con đã được tạo thành công.');
    }

    public function show(SubCategory $subcategory)
    {
        return view('admin.subcategories.show', compact('subcategory'));
    }

    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subcategories,name,' . $subcategory->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->only(['name', 'category_id', 'status']);
        $data['slug'] = Str::slug($request->name);

        $subcategory->update($data);

        return redirect()->route('subcategories.index')->with('success', 'Danh mục con đã được cập nhật.');
    }

    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('success', 'Danh mục con đã bị xóa.');
    }
}
