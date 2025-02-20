<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Requires: Authenticated user permissions.
     */
    public function create()
    {
        if (auth()->user()->role == 'admin') {
            $threads = Thread::all();
        } else {
            $threads = Thread::where('name', '!=', 'Announcements')->get();
        }

        return view('posts.create', compact('threads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Requires: Authenticated user permissions.
     */
    public function store(Request $request)
    {
        // Validate the request data.
        $validatedData = $request->validate([
            'title' => ['required', 'string'],
            'thread_id' => ['required', 'exists:threads,id'],
            'content' => ['required', 'string'],
        ]);

        if (auth()->user()->role != 'admin') {
            $thread = Thread::find($validatedData['thread_id']);
            if ($thread->name == 'Announcements') {
                return redirect()
                    ->route('posts.create')
                    ->with('status', 'You do not have permission to post to the Announcments thread.');
            }
        }

        // Create the post and associate it with the authenticated user.
        $post = Post::create([
            'title' => $validatedData['title'],
            'thread_id' => $validatedData['thread_id'],
            'content' => $validatedData['content'],
            'author_id' => auth()->id(),
        ]);

        // Redirect to the thread with a success message.
        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * (No explicit admin or auth requirements; adjust as needed.)
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Requires: Admin permissions or post author.
     */
    public function edit(Post $post)
    {
        // Ensure the user is authorized to edit the post.
        abort_unless(auth()->id() === $post->author_id || auth()->user()->isAdmin(), 403);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Requires: Admin permissions or post author.
     */
    public function update(Request $request, Post $post)
    {
        // Ensure the user is authorized to update the post.
        abort_unless(auth()->id() === $post->author_id || auth()->user()->isAdmin(), 403);

        // Validate the request data.
        $validatedData = $request->validate([
            'content' => ['required', 'string'],
        ]);

        // Update the post with the validated data.
        $post->update($validatedData);

        // Redirect with a success message.
        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Requires: Admin permissions or post author.
     */
    public function destroy(Post $post)
    {
        // Ensure the user is authorized to delete the post.
        abort_unless(auth()->id() === $post->author_id || auth()->user()->isAdmin(), 403);

        $post->delete();

        return redirect()
            ->route('threads.show', $post->thread_id)
            ->with('status', 'Post deleted successfully.');
    }

    /**
     * Display a listing of the resource for a specific thread.
     */
    public function reply(Post $post, Request $request)
    {
        // Validate the request data.
        $validatedData = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $reply = Reply::create([
            'content' => $validatedData['content'],
            'author_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        // Redirect to the thread with a success message.
        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'Reply created successfully.');
    }

    /**
     * Delete a reply.
     */
    public function deleteReply(Reply $reply)
    {
        abort_unless(auth()->id() === $reply->author_id || auth()->user()->isAdmin(), 403);

        $reply->delete();

        return redirect()
            ->route('posts.show', $reply->post_id)
            ->with('status', 'Reply deleted successfully.');
    }
}
