<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('profile.edit') }}"
                    class="text-gray-400 hover:text-white transition">&larr; Back to Profile</a>

                <h1 class="text-4xl font-bold mt-4">📋 Login History</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm mb-2">Total Logins</h3>
                    <p class="text-3xl font-bold">{{ $histories->total() }}</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm mb-2">Active Sessions</h3>
                    <p class="text-3xl font-bold text-green-400">{{ $activeSessions->count() }}</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-gray-400 text-sm mb-2">Last Login</h3>
                    <p class="text-3xl font-bold">
                        {{ $histories->first()?->logged_in_at?->diffForHumans() ?? 'Never' }}
                    </p>
                </div>

            </div>

            @if($activeSessions->count() > 0)
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">🟢 Active Sessions</h2>
                    <form action="{{ route('login-history.destroy-all') }}" method="POST"
                        onsubmit="return confirm('Logout from all devices?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Logout All
                        </button>
                    </form>
                </div>

                <div class="space-y-3">
                    @foreach($activeSessions as $session)
                    <div class="bg-gray-800 rounded-xl p-4 flex justify-between items-center">
                        <div>
                            <p class="font-medium">{{ $session->user_agent ?? 'Unknown Device' }}</p>
                            <p class="text-gray-400 text-sm">{{ $session->ip_address }} -
                                {{ $session->logged_in_at->diffForHumans() }}</p>
                        </div>
                        <form action="{{ route('login-history.destroy', $session) }}" method="POST"
                            onsubmit="return confirm('Logout from this device?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-800">
                    <h2 class="text-lg font-semibold">📜 Login History</h2>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-800 text-gray-300 text-sm">
                            <tr>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">IP Address</th>
                                <th class="px-6 py-4">User Agent</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">

                            @forelse($histories as $history)

                            <tr class="hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4 text-gray-300">
                                    {{ $history->logged_in_at->format('M d, Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $history->ip_address ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $history->user_agent ? mb_substr($history->user_agent, 0, 50) : '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if($history->logged_out_at)
                                    <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        Logged Out
                                    </span>
                                    @else
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                    @endif
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400">
                                    No Login History Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $histories->links() }}
            </div>

        </div>

    </div>

</x-app-layout>
