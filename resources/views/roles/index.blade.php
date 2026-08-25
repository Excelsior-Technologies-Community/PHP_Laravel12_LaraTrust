<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-7xl mx-auto px-6">

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

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div>
                    <h1 class="text-4xl font-bold tracking-tight">
                        🔐 Role Management
                    </h1>
                    <p class="text-gray-400 mt-1">
                        Create and manage roles with permissions
                    </p>
                </div>

                <a href="{{ route('roles.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 px-5 py-3 rounded-xl font-semibold shadow-md transition">
                    + Add Role
                </a>

            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-800 text-gray-300 text-sm">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Display Name</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Permissions</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">

                            @forelse($roles as $role)

                            <tr class="hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4 text-gray-300">
                                    #{{ $role->id }}
                                </td>

                                <td class="px-6 py-4 font-medium">
                                    {{ $role->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $role->display_name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $role->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $role->permissions->count() }} permissions
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('roles.edit', $role) }}"
                                            class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                            onsubmit="return confirm('Delete this role?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-400">
                                    No Roles Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $roles->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
