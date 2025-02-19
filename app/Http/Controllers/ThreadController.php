<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * (No explicit admin or auth requirements; adjust as needed.)
     */
    public function index()
    {
        $threads = Thread::orderBy('created_at', 'desc')->get();
        // Assuming your view is located at resources/views/threads/index.blade.php
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Requires: Authenticated user permissions.
     */
    public function create()
    {
        // Only authenticated users should be allowed to create a thread.
        // The auth middleware should already ensure that the user is logged in.
        return view('threads.create');
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
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Optionally, assign the thread to the currently authenticated user
        // if your threads table is intended to be linked to a creator.
        // For now, we simply create the thread.
        $thread = Thread::create($validatedData);

        // Redirect to the thread's page or thread listing with a success message.
        return redirect()->route('threads.show', $thread)
                         ->with('status', 'Thread created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * (No explicit admin or auth requirements; adjust as needed.)
     */
    public function show(Thread $thread)
    {
        // Display the selected thread.
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Requires: Admin permissions (or additional auth checks for thread owner).
     */
    public function edit(Thread $thread)
    {
        // TODO: Implement an authorization check.
        // Example: abort_unless(Auth::user()->isAdmin() || Auth::id() === $thread->user_id, 403);
        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Requires: Admin permissions (or additional auth checks for thread owner).
     */
    public function update(Request $request, Thread $thread)
    {
        // TODO: Implement an authorization check.
        // Example: abort_unless(Auth::user()->isAdmin() || Auth::id() === $thread->user_id, 403);

        // Validate the request data.
        $validatedData = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Update the thread with the validated data.
        $thread->update($validatedData);

        // Redirect with a success message.
        return redirect()->route('threads.show', $thread)
                         ->with('status', 'Thread updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Requires: Admin permissions.
     */
    public function destroy(Thread $thread)
    {
        // TODO: Ensure this action is authorized for an admin.
        // Example: abort_unless(Auth::user()->isAdmin(), 403);

        $thread->delete();

        // Redirect to the thread list page with a status message.
        return redirect()->route('threads.index')
                         ->with('status', 'Thread deleted successfully.');
    }
}
