<?php

namespace App\Helpers\Extensions;

use App\Models\Article;
use Illuminate\Support\Carbon;
/**
 * MyClass Class Index Comment
 *
 * @category Class
 * @package  MyPackage
 * @author    Thuyetpv
 * @link
 *
 */
class Index
{
    /**
     * @param int $user_id User-id
     *
     * @return string
     */
    public static function getArticleByCategory($type, $category_id = 0)
    {
        $articles = collect([]);
        if ($type === 'nav') {
            $articles = Article::with(['user'])->where('category_id', $category_id)->orderBy('updated_at', 'desc')->take(4)->get();
        }
        if ($type === 'weekly') {
            $articles = Article::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->orderBy('views', 'desc')->take(12)->get();
        }
        return $articles;
    }
}
