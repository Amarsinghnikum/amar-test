@extends('layouts.app')

@section('content')
    <h2>All Blog Posts</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->content }}</p>
            <p class="card-text"><small class="text-muted">Published on {{ $post->publication_date->format('M d, Y') }}</small></p>
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit</a>
            <button type="button" class="btn btn-danger" onclick="deletePost('{{ $post->id }}')">Delete</button>
        </div>
    </div>
   @endforeach

    <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
@endsection
