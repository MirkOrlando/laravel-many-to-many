<?php

namespace App\Http\Controllers\admin;

use App\Post;
use App\Category;
use App\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Mail\PostCreated;
use App\Mail\PostUpdatedAdminMessage;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Auth::user()->posts;
        // $posts = Post::orderByDesc('id')->get();
        $posts = Post::where(('user_id'), Auth::user()->id)->orderByDesc('id')->get();
        // dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $slug = Str::slug($request->title, '-');
        $validated['slug'] = $slug;
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('cover_img')) {
            $request->validate([
                'cover_img' => 'nullable|image|max:5000'
            ]);

            $path = Storage::put('post_img', $request->cover_img);

            $validated['cover_img'] = $path;
        }
        // dd($validated);
        // dd($request->tags);
        $new_post = Post::create($validated);
        $new_post->tags()->attach($request->tags);

        //return (new PostCreated($new_post))->render();

        //ddd($request->user());

        Mail::to($request->user())->send(new PostCreated($new_post));


        return redirect()->route('admin.posts.index')->with('message', "Post Created Successfully");
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // dd($post);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        $tagsSelected = [];
        foreach ($post->tags as $tag) {
            array_push($tagsSelected, $tag->name);
        }
        // dd($tagsSelected);
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'tagsSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        if (Auth::id() == $post->user_id) {
            $validated = $request->validated();
            $slug = Str::slug($request->title, '-');
            $validated['slug'] = $slug;
            //dd($validated);
            if ($request->hasFile('cover_img')) {
                $request->validate([
                    'cover_img' => 'nullable|image|max:5000'
                ]);

                $path = Storage::put('post_img', $request->cover_img);

                $validated['cover_img'] = $path;
            }

            $post->update($validated);
            $post->tags()->sync($request->tags);

            Mail::to('admin@example.com')->send(new PostUpdatedAdminMessage($post));

            return redirect()->route('admin.posts.index')->with('message', "$post->title Updated Successfully");
        } else {
            dd('Access Not Authorised');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "$post->title Deleted successfully");
    }
}