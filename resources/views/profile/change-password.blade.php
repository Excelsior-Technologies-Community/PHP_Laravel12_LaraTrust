<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('profile.edit') }}"
                    class="text-gray-400 hover:text-white transition">&larr; Back to Profile</a>

                <h1 class="text-4xl font-bold mt-4">🔒 Change Password</h1>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-xl">

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">Current Password</label>
                        <input type="password" name="current_password"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('current_password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">New Password</label>
                        <input type="password" name="password"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-xl font-semibold transition">
                            Update Password
                        </button>

                        <a href="{{ route('profile.edit') }}"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-xl text-center font-semibold transition">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
