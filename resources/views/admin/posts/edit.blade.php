@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit post "{{ $post->title }}"</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.posts.update', $post->slug) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    aria-describedby="titleHelper" placeholder="Title" value="{{ old('title', $post->title) }}">
                <small id="titleHelper" class="form-text text-muted">Post's title here</small>
            </div>
            <div class="mb-3">
                <label for="cover_img" class="form-label">Cover Image</label>
                <input type="text" class="form-control @error('cover_img') is-invalid @enderror" name="cover_img"
                    id="cover_img" aria-describedby="coverHelper"
                    placeholder="https://gametimers.it/wp-content/uploads/2022/02/naruto-scaled.jpg"
                    value="{{ old('cover_img', $post->cover_img) }}">
                <small id="coverHelper" class="form-text text-muted">Post's cover image urls here</small>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Categories</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="" {{ !$post->category_id ? 'selected' : '' }}>Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == old('category_id', $post->category_id ? '$post->category_id' : '') ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('contemt') is-invalid @enderror" name="content" id="content" rows="4">{{ old('content', $post->content) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </form>
    </div>
@endsection
