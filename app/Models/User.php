<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logAttributes = ['name', 'email', 'status'];

    protected static $logName = 'user';

    protected static $recordEvents = ['created', 'updated', 'deleted'];
}
