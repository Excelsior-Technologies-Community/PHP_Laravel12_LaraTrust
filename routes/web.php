<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $totalUsers = User::count();
    $totalRoles = Role::count();
    $totalPermissions = Permission::count();

    return view('dashboard', compact(
        'totalUsers',
        'totalRoles',
        'totalPermissions'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::get('/users-export', [UserController::class, 'export'])
    ->name('users.export');

Route::get('/check-role', function () {

    if (!auth()->check()) {
        return "Please Login First";
    }

    return auth()->user()->hasRole('admin')
        ? 'User is Admin'
        : 'User is Not Admin';

})->middleware('auth');

require __DIR__.'/auth.php';