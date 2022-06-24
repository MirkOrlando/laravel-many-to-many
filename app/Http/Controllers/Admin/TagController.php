<?php

namespace App\Http\Controllers\admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderByDesc('id')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $val_data = $request->all();
        $slug = Str::slug($request->name);
        $val_data['slug'] = $slug;
        //dd($val_data);
        Tag::create($val_data);
        return redirect()->back()->with('message', "Tag \"$slug\" created successfulli");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $val_data = $request->all();
        $slug = Str::slug($request->name);
        $val_data['slug'] = $slug;
        //dd($val_data);
        $tag->update($val_data);
        return redirect()->back()->with('message', "Tag \"$slug\" updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('message', "Tag \"$tag->slug\" deleted successfully");
    }
}