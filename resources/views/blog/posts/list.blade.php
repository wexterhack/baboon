@extends('layouts.base')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ( !$posts->count() )
        <div class="alert alert-danger text-center" role="alert">
            <h5>There is no post till now. Login and write a new post now!!!</h5>
        </div>
    @else
        <div class="">
            @foreach( $posts as $post )
                <div class="list-group">
                    <div class="list-group-item">
                        <h3><a href="{{ route('blog.post:details', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                            @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
                                @if($post->active == '1')
                                    <button class="btn" style="float: right"><a href="{{ route('blog.post:edit', ['slug'=>$post->slug]) }}">Edit Post</a></button>
                                @else
                                    <button class="btn" style="float: right"><a href="{{ route('blog.post:edit', ['slug'=>$post->slug]) }}">Edit Draft</a></button>
                                @endif
                            @endif
                        </h3>
                        <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} by <a href="{{ route('blog.post:by_author', ['author_id'=>$post->author_id]) }}">{{ $post->author->name }}</a></p>
                    </div>
                    <div class="list-group-item">
                        <article>
                            {!! Str::limit($post->content, $limit = 1500, $end = '....... <a href='.url("/".$post->slug).'>Read More</a>') !!}
                        </article>
                    </div>
                </div>
            @endforeach
            {!! $posts->render() !!}
        </div>
    @endif
@endsection
