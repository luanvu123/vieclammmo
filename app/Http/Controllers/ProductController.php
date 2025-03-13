<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['customer', '2fa']);
    }

    public function index()
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $products = Product::where('customer_id', $customer->id)->latest()->get();

        return view('admin_customer.product_index', compact('products'));
    }


    public function create()
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $categories = Category::with('subcategories')->get();
        return view('admin_customer.product_create', compact('categories'));
    }


    public function store(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'nullable|string',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'customer_id' => $customer->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Product::generateUniqueSlug($request->name),
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'cashback_percentage' => $request->cashback_percentage,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function edit($id)
    {

        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $product = Product::findOrFail($id);
        if ($product->customer_id != $customer->id) {
            abort(403, 'Không có quyền truy cập.');
        }
        $categories = Category::with('subcategories')->get();
        return view('admin_customer.product_edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $product = Product::findOrFail($id);
        if ($product->customer_id != $customer->id) {
            abort(403, 'Không có quyền truy cập.');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'nullable|string',
            'cashback_percentage' => 'nullable|numeric|min:0|max:100',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($imagePath);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Product::generateUniqueSlug($request->name, $id),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'cashback_percentage' => $request->cashback_percentage,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $product = Product::findOrFail($id);

        if ($product->customer_id != $customer->id) {
            abort(403, 'Không có quyền truy cập.');
        }

        // Xóa ảnh nếu có
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã bị xóa.');
    }
}
