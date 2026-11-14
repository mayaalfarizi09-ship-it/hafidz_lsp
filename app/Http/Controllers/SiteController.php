<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Gallery;
use App\Models\Product;

class SiteController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'products' => Product::orderBy('price')->take(3)->get(),
            'articles' => Article::latest()->take(4)->get(),
        ]);
    }

    public function profile()
    {
        return view('pages.profile');
    }

    public function products()
    {
        return view('pages.products', ['products' => Product::orderBy('price')->get()]);
    }

    public function articles()
    {
        return view('pages.articles', ['articles' => Article::latest()->get()]);
    }

    public function article(string $slug)
    {
        return view('pages.article', ['article' => Article::where('slug', $slug)->firstOrFail()]);
    }

    public function gallery()
    {
        return view('pages.gallery', ['galleries' => Gallery::latest()->get()]);
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
