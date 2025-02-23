<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
     public function category()
    {
        return view('pages.category');
    }
}
