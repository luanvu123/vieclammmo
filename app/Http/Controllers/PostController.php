<?php

namespace App\Http\Controllers;

use App\Models\GenrePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    /**
     * Hiển thị form tạo bài viết mới
     */
    public function create()
    {
        // Lấy danh sách thể loại bài viết
        $genres = GenrePost::where('status', 1)->get();
        // Lấy ID của khách hàng đang đăng nhập
        $customerId = auth('customer')->id();

        // Lấy danh sách bài viết của khách hàng, kèm theo thể loại bài viết
        $posts = Post::where('customer_id', $customerId)
            ->with('genrePost')
            ->latest()
            ->paginate(10);
        return view('customer.posts.create', [
            'genres' => $genres,
            'posts' => $posts
        ]);
    }

    /**
     * Lưu bài viết mới
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'genre_post_id' => 'required|exists:genre_posts,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Tạo slug từ tên bài viết
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Thêm ID khách hàng và trạng thái mặc định
        $validatedData['customer_id'] = auth('customer')->id();
        $validatedData['status'] = 1;
        $validatedData['view'] = 0;

        // Tạo bài viết
        $post = Post::create($validatedData);

        return redirect()->back()->with('success', 'Bài viết đã được tạo thành công.');
    }

    /**
     * Hiển thị chi tiết bài viết
     */


    /**
     * Hiển thị form chỉnh sửa bài viết
     */
    public function edit(Post $post)
    {
        // Kiểm tra quyền sở hữu bài viết
        if ($post->customer_id !== auth('customer')->id()) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này');
        }

        $genres = GenrePost::where('status', 1)->get();
        $customerId = auth('customer')->id();

        // Lấy danh sách bài viết của khách hàng, kèm theo thể loại bài viết
        $posts = Post::where('customer_id', $customerId)
            ->with('genrePost')
            ->latest()
            ->paginate(10);
        return view('customer.posts.edit', [
            'post' => $post,
            'genres' => $genres,
            'posts' => $posts
        ]);
    }

    /**
     * Cập nhật bài viết
     */
    public function update(Request $request, Post $post)
    {
        if ($post->customer_id != auth('customer')->id()) {
            abort(403, 'Bạn không có quyền cập nhật bài viết này');
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'genre_post_id' => 'required|exists:genre_posts,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Cập nhật slug nếu tên thay đổi
        if ($validatedData['name'] !== $post->name) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $post->update($validatedData);

        return redirect()->back()->with('success', 'Bài viết đã được cập nhật thành công.');
    }


    /**
     * Xóa bài viết
     */
    public function destroy(Post $post)
    {
        // Kiểm tra quyền sở hữu bài viết
        if ($post->customer_id != auth('customer')->id()) {
            abort(403, 'Bạn không có quyền xóa bài viết này');
        }

        // Xóa ảnh liên quan
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Xóa bài viết
        $post->delete();

        return redirect()->back()
            ->with('success', 'Bài viết đã được xóa thành công.');
    }
  
}
