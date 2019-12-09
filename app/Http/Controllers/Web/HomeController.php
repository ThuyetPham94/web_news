<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\ArticleService;

class HomeController extends Controller
{
    private $articleService;
    function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    function index()
    {
        return view('frontend.function.index', [
            'title' => 'web bao',
            'description' => 'news',
            'keywords' => 'web bao'
        ]);
    }
}
