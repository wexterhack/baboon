<?php

namespace App\Http\Controllers\Blog\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Models\Auth\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('administrator','moderator', 'publisher')) {
            if (!$request->isMethod('POST')) {
                return view('blog.posts.create');
            }
            else {
                $post = new Post();
                $post->title = $request->get('title');
                $post->content = $request->get('content');
                $post->slug = Str::slug($post->title);

                $duplicate = Post::where('slug', $post->slug)->first();
                if ($duplicate) {
                    return redirect(route('blog.post:create'))
                        ->withErrors('Title already exists.')->withInput();
                }

                $post->author_id = $request->user()->id;
                if ($request->has('save')) {
                    $post->published = 0;
                    $message = 'Post saved successfully';
                } else {
                    $post->published = 1;
                    $message = 'Post published successfully';
                }
                $saved = $post->save();
                if ($saved){
                    try {
                        Post::createIndex($shards = null, $replicas = null);
                    }
                    catch (Exception $e){}
                    finally {
                        $post = Post::where('slug', $post->slug)->first();
                        $post->addToIndex();
                    }
                }
                return redirect(route('blog.post:edit', ['slug'=>$post->slug]))
                    ->with('message', $message);
            }

        } else {
            return redirect('/')->withErrors('You have not sufficient permissions for writing post');
        }
    }

    public function details(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        if (!$post) {
            return redirect('/')->withErrors('requested page not found');
        }
        $comments = $post->comments;
        return view('blog.posts.details')
            ->with('post', $post)
            ->with('comments', $comments);
    }

    public function edit(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin())) {
            return view('blog.posts.edit')->with('post', $post);
        }

        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        $post_id = $request->input('post_id');
        $post = Post::find($post_id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->input('title');
            $slug = Str::slug($title);
            $duplicate = Post::where('slug', $slug)->first();
            if ($duplicate) {
                if ($duplicate->id != $post_id) {
                    return redirect('edit/' . $post->slug)->withErrors('Title already exists.')->withInput();
                } else {
                    $post->slug = $slug;
                }
            }
            $post->title = $title;
            $post->content = $request->input('content');

            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect($landing)->withMessage($message);

        } else {
            return redirect("/")->withErrors("you have not sufficient permissions");
        }
    }

    public function delete(Request $request, $id)
    {
        $post = Post::find($id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';
        } else {
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
        }
        return redirect('/')->with($data);
    }

    public function getByAuthor(int $author_id){
        $posts = Post::where('author_id', $author_id)->where('published', 1)->orderBy('created_at','desc')->paginate(5);
        $title = User::find($author_id)->name;
        return view('blog.posts.list')
            ->with('posts', $posts)
            ->with('title', $title);
    }
}
