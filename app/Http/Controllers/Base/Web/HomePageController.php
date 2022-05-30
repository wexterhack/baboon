<?php

namespace App\Http\Controllers\Base\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;


class HomePageController extends Controller
{
    public function show()
    {
        try {
            Post::createIndex($shards = null, $replicas = null);
            Post::reindex();
        } finally {
            $posts = Post::where('published', 1)->orderBy('created_at', 'desc')->paginate(5);
            $title = 'Latest Posts';

            return view('base.home')
                ->with('posts', $posts)
                ->with('title', $title);
        }
    }
}
