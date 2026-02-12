# PHP_LARAVEL12_LARATRUST

```php
- Laravel 12 Based Role & Permission Management Web Application
- Built using Clean MVC Architecture
- Laravel 12 based Access Control System using Laratrust Package
```

# Key Features
```php
- User Authentication (Login / Register)
- Role Based Access Control (RBAC)
- Permission Based Authorization
- Route Middleware Protection
- Database Driven Role System
- Clean MVC Architecture
- Secure Access Management
- Laravel 12 Compatible
- Scalable Enterprise Structure
- Beginner Friendly Setup
```

# Step 1: Install Fresh Laravel 12 Application
Open Terminal / Command Prompt:
```php
composer create-project laravel/laravel:^12.0 PHP_LARAVEL12_LARATRUST
```
Move into project directory:
```php
cd PHP_LARAVEL12_LARATRUST
```
Generate application key:
```php
php artisan key:generate
```

# Explanation
```php
- Installs fresh Laravel 12 project
- Generates unique application key
- Required for encryption, sessions, and security
```

# Step 2: Configure Environment & Database
Open .env file and update:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=php_laravel12_laratrust
DB_USERNAME=root
DB_PASSWORD=
```
Create database in phpMyAdmin:
```php
php_laravel12_laratrust
```
Run default migrations:
```php
php artisan migrate
```
# Explanation
```php
- .env manages environment settings
```

# Step 3: Install Authentication (Laravel Breeze)
Install Breeze:
```php
composer require laravel/breeze --dev
```
Install scaffolding:
```php
php artisan breeze:install
```
Install frontend dependencies:
```php
- npm install
- npm run dev
```
Run migrations:
```php
php artisan migrate
```
Breeze provides:
```php
- Login
- Register
- Password Reset
- Auth Middleware Protection
- Clean Blade UI
```
Authentication is required before implementing roles.

# Step 4: Install Laratrust Package
Install package:
```php
composer require santigarcor/laratrust
```
# Explanation
```php
- Laratrust is an Eloquent-based package for managing:
- Roles
- Permissions
- User-Role relationships
- Role-Permission relationships
```

# Step 5: Publish Laratrust Configuration
```php
php artisan vendor:publish --provider="Laratrust\LaratrustServiceProvider"
```

# Step 6: Setup Laratrust Tables
Run setup command:
```php
php artisan laratrust:setup
```
Then run migrations:
```php
php artisan migrate
```

# Step 7: Configure User Model
Open:
```php
app/Models/User.php
```
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laratrust\Traits\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRolesAndPermissions;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```

# Step 8: Create Role & Permission Seeder
Create seeder:
```php
php artisan make:seeder RolePermissionSeeder
```
Open:
```php
database/seeders/RolePermissionSeeder.php
```
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $adminRole =Role::create([
    'name' => 'Admin',
    'slug' => 'admin'
]);
       

        $userRole = Role::create([
    'name' => 'Admin',
    'slug' => 'admin'
]);

        // Create Permission
        $createPost = Permission::create([
            'name' => 'create-post',
            'display_name' => 'Create Post',
            'description' => 'Create Post Permission'
        ]);

        $adminRole->attachPermission($createPost);

        // Create Admin User
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $user->attachRole($adminRole);
    }

    
}
```
Run seeder:
```php
php artisan db:seed --class=RolePermissionSeeder
```

# Step 9: Protect Routes Using Role
Open:
```php
routes/web.php
```
```php
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
```

# Step 10: Run Laravel Project
Start server:
```php
php artisan serve
```

Open browser:
```php
http://127.0.0.1:8000
```
<img width="1237" height="627" alt="image" src="https://github.com/user-attachments/assets/dd36e188-2130-407f-8e29-391b1f9d94b7" />

```php
http://127.0.0.1:8000/check-role
```
<img width="811" height="370" alt="image" src="https://github.com/user-attachments/assets/9e2120d1-0193-4fe3-9962-1b8ddc07613d" />

# Project Folder Structure
```php
PHP_LARAVEL12_LARATRUST
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   └── Permission.php
│   └── Http/
│       └── Controllers/
│
├── config/
│   └── laratrust.php
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── routes/
│   └── web.php
│
├── resources/
│   └── views/
│
├── .env
├── artisan
└── composer.json
```

# Explanation
```php
- Role Based Access Control (RBAC)
- Permission Based Authorization
- Secure Route Protection
- Database Driven Access System
- Middleware Integration
- Enterprise Ready Architecture
- Laravel 12 Compatible
```

              
