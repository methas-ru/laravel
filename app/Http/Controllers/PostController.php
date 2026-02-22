<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // READ: list all posts
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // CREATE: show form
    public function create()
    {
        return view('posts.create');
    }

    // CREATE: save to DB
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create($data);

        return redirect()->route('posts.index')
                        ->with('status', 'Post created!');
    }

    // READ: single post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // UPDATE: show edit form
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // UPDATE: save changes
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($data);

        return redirect()->route('posts.index')
                        ->with('status', 'Post updated!');
    }

    // DELETE
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('status', 'Post deleted!');
    }
}