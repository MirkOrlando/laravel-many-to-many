@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>All Tags</h1>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col">
                <form action="{{ route('admin.tags.store') }}" method="post" class="d-flex pr-3">
                    @csrf
                    <div class="mb-3 mr-3 flex-grow-1">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" aria-describedby="nameHelper" placeholder="New Tag Name"
                            value="{{ old('name') }}">
                        <small id="nameHelper" class="form-text text-muted">Add a New Tag</small>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
            <div class="col">
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Posts Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td scope="row">{{ $tag->id }}</td>
                                <td>
                                    <form id="tag-{{ $tag->id }}"
                                        action="{{ route('admin.tags.update', $tag->slug) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input class="border-0 bg-transparent" type="text" name="name" id="name"
                                            value="{{ $tag->name }}">
                                    </form>
                                </td>
                                <td class="text-center">{{ count($tag->posts) }}</td>
                                <td class="d-flex" style="gap: 0.5rem">
                                    <button form="tag-{{ $tag->id }}" type="submit"
                                        class="btn btn-secondary btn-sm">Update</button>
                                    <form action="{{ route('admin.tags.destroy', $tag->slug) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td scope="row">
                                    <p>No Tags found! Add your first Tag</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
