<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('users.index') }}"
                    class="text-gray-400 hover:text-white transition">&larr; Back to Users</a>

                <h1 class="text-4xl font-bold mt-4">🗑 Deleted Users</h1>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-800 text-gray-300 text-sm">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Deleted At</th>
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

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $user->deleted_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('users.restore', $user->id) }}"
                                            class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Restore
                                        </a>

                                        <form action="{{ route('users.force-delete', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Permanently delete?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Force Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    No Deleted Users Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
