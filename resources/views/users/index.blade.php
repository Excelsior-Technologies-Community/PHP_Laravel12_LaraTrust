<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-8">

        <div class="max-w-7xl mx-auto px-6">

            @if(session('success'))

                <div id="success-alert"
                    class="mb-6 flex items-center justify-between bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg">

                    <div class="flex items-center gap-3">

                        <span class="text-xl">✅</span>

                        <span class="font-medium">
                            {{ session('success') }}
                        </span>

                    </div>

                    <button onclick="document.getElementById('success-alert').remove()" class="text-white text-xl">

                        &times;

                    </button>

                </div>

                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.remove();
                        }
                    }, 3000);
                </script>

            @endif

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">

                <div>
                    <h1 class="text-4xl font-bold">
                        🚀 User Management
                    </h1>

                    <p class="text-gray-400 mt-1">
                        Manage users, roles and permissions
                    </p>
                </div>

                <a href="{{ route('users.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 px-5 py-3 rounded-xl font-semibold shadow-lg transition">

                    + Add User

                </a>

            </div>

            {{-- Search Card --}}
            <div class="bg-gray-900 rounded-2xl shadow-lg p-6 mb-8 border border-gray-800">

                <form method="GET" class="flex gap-3">

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="🔍 Search by Name or Email..."
                        class="flex-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    <button class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition">

                        Search

                    </button>

                </form>

            </div>

            {{-- User Table --}}
            <div class="bg-gray-900 rounded-2xl shadow-xl overflow-hidden border border-gray-800">

                <div class="p-5 border-b border-gray-800">

                    <h2 class="text-xl font-semibold">
                        👥 Users List
                    </h2>

                </div>

                <table class="w-full">

                    <thead>

                        <tr class="bg-gray-800 text-gray-300">

                            <th class="text-left px-6 py-4">#ID</th>
                            <th class="text-left px-6 py-4">Name</th>
                            <th class="text-left px-6 py-4">Email</th>
                            <th class="text-center px-6 py-4">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4">
                                    {{ $user->id }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $user->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-3">

                                        <a href="{{ route('users.edit', $user) }}"
                                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium">

                                            ✏ Edit

                                        </a>

                                        <form action="{{ route('users.destroy', $user) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Delete User?')"
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium">

                                                🗑 Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-8 text-gray-400">

                                    No Users Found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            <div class="mt-6">

                {{ $users->links() }}

            </div>

        </div>

    </div>

</x-app-layout>