@extends('layouts.base')

@section('title')
    @if($post)
        {{ $post->title }}
    @else
        Page does not exist
    @endif
@endsection

@section('content')
<h1>{{ $post->title }}</h1>
    <div class="row">
        <div class="col-12">{{ $post->content }}</div>
    </div>
@endsection
