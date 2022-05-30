@extends('layouts.base')

@section('title')
    Add New Post
@endsection

@section('content')
    <form action="{{ route('blog.post:create') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="input-group mb-3">
            <span class="input-group-text" id="post-title">Title</span>
            <input type="text" required="required" value="{{ old('title') }}" placeholder="Enter title here" name="title" class="form-control" aria-label="Title" aria-describedby="post-title" />
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Body</span>
            <textarea name="content" class="form-control" aria-label="Post body">{{ old('content') }}</textarea>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <input type="submit" name="publish" class="btn btn-success me-md-2" value="Publish"/>
            <input type="submit" name="save" class="btn btn-secondary" value="Save Draft" />
        </div>
    </form>
@endsection
