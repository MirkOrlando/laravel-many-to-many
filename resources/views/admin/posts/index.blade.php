@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="top mb-2 d-flex justify-content-between align-items-center">
            <h1>All Posts</h1>
            <div class="action">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">New Post</a>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-striped">
            <thead class="thead-inverse">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Crated At</th>
                    <th>Cover Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td scope="row">{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                        <td><img width="100px" src="{{ asset('storage/' . $post->cover_img) }}"
                                alt="cover img {{ $post->title }}"></td>
                        <td>
                            <a href="{{ route('admin.posts.show', $post->slug) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('admin.posts.edit', $post->slug) }}"
                                class="btn btn-secondary btn-sm">Edit</a>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#delete-post-{{ $post->id }}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="delete-post-{{ $post->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="postTitleId{{ $post->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete post {{ $post->title }}</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this Post?
                                            The operation is destructive.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <form action="{{ route('admin.posts.destroy', $post->slug) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Confirm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td scope="row">
                            <p>No posts to show yet. Create your first post!</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
