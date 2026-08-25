<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('users.index') }}"
                    class="text-gray-400 hover:text-white transition">&larr; Back to Users</a>

                <h1 class="text-4xl font-bold mt-4">➕ Add User</h1>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-xl">

                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input type="password" name="password"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="status"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>
                        @error('status')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Role</label>
                        <select name="role_id"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name ?? $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Avatar</label>
                        <input type="file" name="avatar" accept="image/*"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                        @error('avatar')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-xl font-semibold transition">
                            Create User
                        </button>

                        <a href="{{ route('users.index') }}"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-xl text-center font-semibold transition">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
