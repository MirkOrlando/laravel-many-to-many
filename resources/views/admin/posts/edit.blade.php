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
        <form action="{{ route('admin.posts.update', $post->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                    aria-describedby="titleHelper" placeholder="Title" value="{{ old('title', $post->title) }}">
                <small id="titleHelper" class="form-text text-muted">Post's title here</small>
            </div>
            <div class="mb-3 d-flex">
                <img width="100px" src="{{ asset('storage/' . $post->cover_img) }}" alt="{{ $post->title }}">
                <div class="pl-3">
                    <label for="cover_img" class="form-label">Post's Img</label>
                    <input type="file" class="form-control @error('cover_img') is-invalid @enderror" name="cover_img"
                        id="cover_img" aria-describedby="coverHelper">
                    <small id="coverHelper" class="form-text text-muted">Post's cover image urls here</small>
                </div>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Categories</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="" {{ !$post->category_id ? 'selected' : '' }}>Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $post->category_id && $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <select multiple class="form-control" name="tags[]" id="tags" aria-label="Tags">
                    <option value="" disabled>Select a tag</option>
                    @forelse ($tags as $tag)
                        <option value="{{ $tag->id }}"
                            {{ old('tags', $post->tags) ? (in_array($tag->name, old('tags', $tagsSelected)) ? 'selected' : '') : '' }}>
                            {{ $tag->name }}</option>
                    @empty
                        <option value="" disabled>No Tags to be selected</option>
                    @endforelse
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
