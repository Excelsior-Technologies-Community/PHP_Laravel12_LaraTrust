<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        // SEARCH
        if ($request->search) {
            $users->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

    // DATE FILTER (FIXED)
    if ($request->from_date && $request->to_date) {
        $users->whereBetween('created_at', [
            Carbon::parse($request->from_date)->startOfDay(),
            Carbon::parse($request->to_date)->endOfDay()
        ]);
    }

        $users = $users->orderBy('id', 'asc')->paginate(4);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'nullable|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->role_id) {
            $user->syncRoles([$request->role_id]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact(
            'user',
            'roles'
        ));
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()
            ->with('success', 'User Deleted Successfully');
    }

    public function export()
    {
        $users = User::select('id', 'name', 'email', 'created_at')->get();

        $fileName = 'users.csv';
        $file = fopen($fileName, 'w+');

        fputcsv($file, ['ID', 'Name', 'Email', 'Created At']);

        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->name,
                $user->email,
                $user->created_at,
            ]);
        }

        fclose($file);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
