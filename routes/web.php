<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::patch('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
});

// admin page
Route::middleware(['auth'])->group(function () {
    Route::GET('/admin', [AdminController::class, 'adminview'])->name('adminpage');
    Route::GET('/admin/AddAnnouncments', [AdminController::class, 'NewAnnouncments'])->name('pages.admin.NewAnnouncments');
});

require __DIR__ . '/auth.php';
