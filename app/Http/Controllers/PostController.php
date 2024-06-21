<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $posts = Post::with(['user:id,name'])
                     ->withCount('comments')
                     ->latest()
                     ->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $request->validate([
            "message" => "required|string|max:255",
        ]);
        Post::create([
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect(route("dashboard"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->loadCount('comments')->load(['user', 'comments.user'])->latest();
        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize("update", $post);

        $validated = $request->validate([
            "message"=> "required|string|max:255",
        ]);
        $post->update($validated);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize("delete", $post);

        $post->delete();
        return redirect(route("dashboard"));
    }
}
