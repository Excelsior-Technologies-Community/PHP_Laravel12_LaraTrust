<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-8">
                <h1 class="text-4xl font-bold tracking-tight">
                    📋 Activity Log
                </h1>
                <p class="text-gray-400 mt-1">
                    Track all user actions in the system
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="bg-gray-800 text-gray-300 text-sm">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Action</th>
                                <th class="px-6 py-4">Subject</th>
                                <th class="px-6 py-4">Properties</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800">

                            @forelse($activities as $activity)

                            <tr class="hover:bg-gray-800/50 transition">

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($activity->causer?->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $activity->causer?->name ?? 'System' }}</p>
                                            <p class="text-gray-400 text-sm">{{ $activity->causer?->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst($activity->description) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $activity->subject_type ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    @if($activity->properties)
                                    <button onclick="toggleProperties({{ $activity->id }})"
                                        class="text-indigo-400 hover:text-indigo-300 text-sm">
                                        View Details
                                    </button>
                                    <div id="properties-{{ $activity->id }}" class="hidden mt-2 bg-gray-800 rounded-lg p-3 text-sm">
                                        <pre class="whitespace-pre-wrap">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @else
                                    -
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-400">
                                    {{ $activity->created_at->format('M d, Y H:i') }}
                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    No Activity Found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>

        </div>

    </div>

    <script>
        function toggleProperties(id) {
            const el = document.getElementById(`properties-${id}`);
            el.classList.toggle('hidden');
        }
    </script>

</x-app-layout>
