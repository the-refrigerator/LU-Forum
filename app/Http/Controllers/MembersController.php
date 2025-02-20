<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MembersController extends Controller
{
    public function index()
    {
        return view('members.index');
    }

    public function show($user)
    {
        return view('members.index', compact('user'));
    }

    public function showAllMembers()
    {
        $admins = User::whereIn('role', ['admin', 'moderator'])->orderBy('created_at', 'desc')->get();
        $members = User::where('role', 'member')->orderBy('created_at', 'desc')->get();
        // dd($admins, $members);
        return view('members.index', compact('admins', 'members'));
    }
}