<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-7xl mx-auto px-6">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
            <div id="success-alert"
                class="mb-6 flex items-center justify-between bg-green-600 text-white px-5 py-4 rounded-xl shadow-lg">

                <div class="flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>

                <button onclick="document.getElementById('success-alert').remove()"
                    class="text-white text-xl">&times;</button>
            </div>

            <script>
                setTimeout(() => {
                    document.getElementById('success-alert')?.remove();
                }, 3000);
            </script>
            @endif

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div>
                    <h1 class="text-4xl font-bold tracking-tight">
                        🚀 User Management
                    </h1>
                    <p class="text-gray-400 mt-1">
                        Manage users, search, filter and export data
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('users.export') }}"
                        class="bg-green-600 hover:bg-green-700 px-5 py-3 rounded-xl font-semibold shadow-md transition">
                        ⬇ Export
                    </a>

                    <a href="{{ route('users.create') }}"
                        class="bg-indigo-600 hover:bg-indigo-700 px-5 py-3 rounded-xl font-semibold shadow-md transition">
                        + Add User
                    </a>

                </div>

            </div>

            {{-- FILTER CARD --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-8 shadow-lg">

                <form method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    <div>
                        <label class="text-sm text-gray-400">Search</label>
                        <input type="text" name="search"
                            value="{{ request('search') }}"
                            placeholder="Name or Email"
                            class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm text-gray-400">From Date</label>
                        <input type="date" name="from_date"
                            value="{{ request('from_date') }}"
                            class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label class="text-sm text-gray-400">To Date</label>
                        <input type="date" name="to_date"
                            value="{{ request('to_date') }}"
                            class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                    </div>

                    <div class="flex gap-2">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 px-4 py-3 rounded-xl font-semibold transition">
                            Filter
                        </button>

                        <a href="{{ route('users.index') }}"
                            class="w-full bg-gray-700 hover:bg-gray-600 px-4 py-3 rounded-xl text-center font-semibold transition">
                            Reset
                        </a>
                    </div>

                </form>

            </div>

            {{-- TABLE CARD --}}
            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                {{-- TABLE HEADER --}}
                <div class="px-6 py-4 border-b border-gray-800">
                    <h2 class="text-lg font-semibold">👥 Users List</h2>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-800 text-gray-300 text-sm">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">

                            @forelse($users as $user)

                            <tr class="hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4 text-gray-300">
                                    #{{ $user->id }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $user->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('users.edit', $user) }}"
                                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('users.destroy', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Delete User?')"
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400">
                                    No Users Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>

    </div>

</x-app-layout>