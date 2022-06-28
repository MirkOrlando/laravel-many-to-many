@extends('layouts.admin')

@section('content')
    <div class="container">
        <img class="mb-3 shadow-lg" style="max-height:400px" src="{{ asset('storage/' . $post->cover_img) }}" alt="">
        <h2>{{ $post->title }}</h2>
        <div class="metadata">
            <div class="category">
                <em><strong>Category:</strong> {{ $post->category ? $post->category->name : 'Uncategorized' }}</em>
            </div>
            <div class="tags">
                <em>
                    <strong>Tags: </strong>
                    @forelse ($post->tags as $tag)
                        #{{ $tag->name }}
                    @empty
                        N/A
                    @endforelse
                </em>
            </div>
        </div>
        <div class="content">
            {{ $post->content }}
        </div>
    </div>
@endsection
