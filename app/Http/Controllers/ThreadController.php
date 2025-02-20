<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $threads = Thread::orderBy('created_at', 'desc')->get();
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Requires: Authenticated user permissions.
     */
    public function create()
    {
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Optionally, assign the thread to the currently authenticated user
        // if your threads table is intended to be linked to a creator.
        // For now, we simply create the thread.
        $thread = Thread::create($validatedData);

        // Redirect to the thread's page or thread listing with a success message.
        return redirect()
            ->route('threads.show', $thread)
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
        // if thread name is 'Announcements' then only edit the description
        if ($thread->name === 'Announcements') {
            $validatedData = $request->validate([
                'description' => ['nullable', 'string'],
            ]);

            $thread->update($validatedData);

            return redirect()
                ->route('threads.show', $thread)
                ->with('status', 'Thread updated successfully.');
        }

        // Validate the request data.
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Update the thread with the validated data.
        $thread->update($validatedData);

        // Redirect with a success message.
        return redirect()
            ->route('threads.show', $thread)
            ->with('status', 'Thread updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Requires: Admin permissions.
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return redirect()
            ->route('threads.index')
            ->with('status', 'Thread deleted successfully.');
    }
}
