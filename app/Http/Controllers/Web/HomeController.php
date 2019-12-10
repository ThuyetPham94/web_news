<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\ArticleService;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    private $articleService;
    function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    function index()
    {
        $articles = $this->articleService->getAll(['user:id,name', 'subCategory:id,name,color', 'category:id,name,color']);
        $sidebar_articles = $articles->where('top', '>', 0)->sortBy('top');
        $latest_articles = $articles->sortByDesc('created_at')->take(15);

        return view('frontend.function.index', [
            'title' => 'web bao',
            'description' => 'news',
            'keywords' => 'web bao',
            'sidebar_articles' => $sidebar_articles,
            'latest_articles' => $latest_articles
        ]);
    }
}
