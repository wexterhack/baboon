<?php

namespace App\Http\Controllers\Base\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request){
        $query = $request->query('query', '');

        $title = 'Search Posts';
        $posts = Post::searchByQuery(array(
                'multi_match' => array(
                    'query' => $query,
                    'fields' => array('title^3', 'content'),
                    "fuzziness" => 2
                ))
        );
        return view('base.search')
            ->with('title', $title)
            ->with('posts', $posts);
    }
}
