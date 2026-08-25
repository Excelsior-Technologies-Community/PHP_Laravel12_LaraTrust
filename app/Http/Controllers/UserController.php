<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->search) {
            $users->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->from_date && $request->to_date) {
            $users->whereBetween('created_at', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay()
            ]);
        }

        if ($request->status) {
            $users->where('status', $request->status);
        }

        if ($request->role) {
            $users->whereHas('roles', function ($q) use ($request) {
                $q->where('roles.id', $request->role);
            });
        }

        $users = $users->orderBy('id', 'asc')->paginate(10);

        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
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
            'status' => 'required|in:active,inactive,banned',
            'role_id' => 'nullable|exists:roles,id',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        if ($request->role_id) {
            $user->syncRoles([$request->role_id]);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('uploads/avatars');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($avatar)->fit(200, 200)->save($path . '/' . $filename);

            $user->update(['avatar' => 'uploads/avatars/' . $filename]);
        }

        activity()->performedOn($user)->causedBy(auth()->user())->log('Created user');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User created successfully']);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:active,inactive,banned',
            'role_id' => 'nullable|exists:roles,id',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        if ($request->role_id) {
            $user->syncRoles([$request->role_id]);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('uploads/avatars');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($avatar)->fit(200, 200)->save($path . '/' . $filename);

            $user->update(['avatar' => 'uploads/avatars/' . $filename]);
        }

        activity()->performedOn($user)->causedBy(auth()->user())->log('Updated user');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User updated successfully']);
        }

        return redirect()->route('users.index')
            ->with('success', 'User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        activity()->performedOn($user)->causedBy(auth()->user())->log('Deleted user');

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        }

        return back()->with('success', 'User Deleted Successfully');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        User::whereIn('id', $request->user_ids)->delete();

        activity()->causedBy(auth()->user())->log('Bulk deleted users');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Users deleted successfully']);
        }

        return back()->with('success', 'Users Deleted Successfully');
    }

    public function bulkStatus(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'status' => 'required|in:active,inactive,banned',
        ]);

        User::whereIn('id', $request->user_ids)->update(['status' => $request->status]);

        activity()->causedBy(auth()->user())->log('Bulk updated user status');

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }

        return back()->with('success', 'Status Updated Successfully');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        activity()->performedOn($user)->causedBy(auth()->user())->log('Restored user');

        return back()->with('success', 'User restored successfully');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        $user->forceDelete();

        return back()->with('success', 'User permanently deleted');
    }

    public function trashed(Request $request)
    {
        $users = User::onlyTrashed();

        if ($request->search) {
            $users->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $users->orderBy('deleted_at', 'desc')->paginate(10);

        return view('users.trashed', compact('users'));
    }

    public function export()
    {
        $users = User::select('id', 'name', 'email', 'status', 'created_at')->get();

        $fileName = 'users.csv';
        $file = fopen($fileName, 'w+');

        fputcsv($file, ['ID', 'Name', 'Email', 'Status', 'Created At']);

        foreach ($users as $user) {
            fputcsv($file, [
                $user->id,
                $user->name,
                $user->email,
                $user->status,
                $user->created_at,
            ]);
        }

        fclose($file);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
