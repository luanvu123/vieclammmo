<?php

namespace App\Http\Controllers;

use App\Models\Category;

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
     public function support()
    {
        return view('pages.support');
    }
   
}
