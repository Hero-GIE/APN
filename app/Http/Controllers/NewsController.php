<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
                    ->orderBy('published_date', 'desc')
                    ->paginate(6);
        
        $featuredNews = News::where('is_published', true)
                            ->where('is_featured', true)
                            ->orderBy('published_date', 'desc')
                            ->take(3)
                            ->get();

        return view('member.news.index', compact('news', 'featuredNews'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
                    ->where('is_published', true)
                    ->firstOrFail();

        $allNews = News::where('is_published', true)
                       ->where('id', '!=', $news->id)
                       ->orderBy('published_date', 'desc')
                       ->get();
                       
        $relatedNews = News::where('is_published', true)
                          ->where('id', '!=', $news->id)
                          ->where('category', $news->category)
                          ->orderBy('published_date', 'desc')
                          ->take(3)
                          ->get();

        return view('member.news.show', compact('news', 'allNews', 'relatedNews'));
    }
}