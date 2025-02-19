<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function adminview()
    {
        return view('pages.admin.admin');
    }
    public function NewAnnouncments()
    {
        return view('pages.admin.AddNewAnnouncments');
    }
    public function AddNewAnnouncments(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Create a new announcement
        $announcement = new Announcement();
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        $announcement->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Announcement added successfully!');
    }

}
