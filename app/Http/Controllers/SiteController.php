<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\GenrePost;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $productCategories = Category::where('status', 'active')
            ->where('type', 'Sản phẩm')
            ->get();

        $serviceCategories = Category::where('status', 'active')
            ->where('type', 'Dịch vụ')
            ->get();

        return view('pages.home', compact('productCategories', 'serviceCategories'));
    }

    public function category()
    {
        return view('pages.category');
    }
     public function faqs()
    {
        return view('pages.faqs');
    }
      public function notice()
    {
        return view('pages.notice');
    }

    
    public function support()
    {
        return view('pages.support');
    }
    public function post(Request $request)
    {
        // Lấy các thể loại có status = 1
        $genres = GenrePost::where('status', 1)->get();

        // Nếu là request Ajax, trả về JSON
        if ($request->ajax()) {
            $postsQuery = Post::where('status', 1)->with('customer');

            // Xử lý tìm kiếm
            if ($request->has('search')) {
                $postsQuery->where('name', 'like', '%' . $request->search . '%');
            }

            // Xử lý lọc theo thể loại
            if ($request->has('genre')) {
                $postsQuery->where('genre_post_id', $request->genre);
            }

            // Lấy posts, sắp xếp mới nhất
            $posts = $postsQuery->orderBy('created_at', 'desc')->paginate(10);

            return response()->json([
                'html' => view('pages.post-list', compact('posts'))->render(),
                'links' => $posts->appends(request()->input())->links('vendor.pagination.default')->render()
            ]);
        }

        // Render view ban đầu
        $posts = Post::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.post', compact('posts', 'genres'));
    }
    public function postDetail($slug)
    {
        // Lấy thông tin bài viết dựa theo slug
        $post = Post::where('slug', $slug)->with('customer', 'genrePost')->firstOrFail();

        // Tăng số lượt xem
        $post->increment('view');

        // Lấy danh sách bài viết liên quan cùng thể loại
        $relatedPosts = Post::where('genre_post_id', $post->genre_post_id)
            ->where('id', '!=', $post->id)
            ->where('status', 1)
            ->latest()
            ->limit(5)
            ->get();

        return view('pages.post_detail', compact('post', 'relatedPosts'));
    }
}
