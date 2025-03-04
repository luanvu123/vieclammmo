<?php

namespace App\Http\Controllers;

use App\Models\GenrePost;
use Illuminate\Http\Request;

class GenrePostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $genrePosts = GenrePost::all();
        return view('admin.genre_posts.index', compact('genrePosts'));
    }

    public function create()
    {
        return view('admin.genre_posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        GenrePost::create($request->all());

        return redirect()->route('genre_posts.index')->with('success', 'Thể loại bài viết đã được thêm!');
    }

   

    public function edit(GenrePost $genrePost)
    {
        return view('admin.genre_posts.edit', compact('genrePost'));
    }

    public function update(Request $request, GenrePost $genrePost)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $genrePost->update($request->all());

        return redirect()->route('genre_posts.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(GenrePost $genrePost)
    {
        $genrePost->delete();
        return redirect()->route('genre_posts.index')->with('success', 'Đã xóa thể loại bài viết!');
    }
}
