<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\LoginHistoryController;
use App\Http\Controllers\ActivityLogController;
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

    Route::get('/profile/password', [PasswordController::class, 'edit'])
        ->name('password.edit');

    Route::put('/profile/password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::get('/profile/login-history', [LoginHistoryController::class, 'index'])
        ->name('login-history.index');

    Route::delete('/profile/login-history/{loginHistory}', [LoginHistoryController::class, 'destroy'])
        ->name('login-history.destroy');

    Route::delete('/profile/login-history/all', [LoginHistoryController::class, 'destroyAll'])
        ->name('login-history.destroy-all');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->name('activity-log.index');

    Route::post('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])
        ->name('users.bulk-destroy');

    Route::post('/users/bulk-status', [UserController::class, 'bulkStatus'])
        ->name('users.bulk-status');

    Route::get('/users/trashed', [UserController::class, 'trashed'])
        ->name('users.trashed');

    Route::get('/users/restore/{id}', [UserController::class, 'restore'])
        ->name('users.restore');

    Route::delete('/users/force-delete/{id}', [UserController::class, 'forceDelete'])
        ->name('users.force-delete');
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
