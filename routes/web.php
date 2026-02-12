<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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


Route::get('/check-role', function () {

    if (!auth()->check()) {
        return "Please Login First";
    }

    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return "User is Admin";
    }

    return "User is Not Admin";
})->middleware('auth');


require __DIR__.'/auth.php';
