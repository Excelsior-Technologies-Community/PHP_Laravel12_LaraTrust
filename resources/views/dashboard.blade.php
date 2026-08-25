<x-app-layout>

    <div class="max-w-7xl mx-auto p-6">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-lg">
                <h2 class="text-sm font-medium opacity-80">Total Users</h2>
                <h1 class="text-4xl font-bold mt-2">{{ $totalUsers }}</h1>
            </div>

            <div class="bg-green-600 text-white p-6 rounded-2xl shadow-lg">
                <h2 class="text-sm font-medium opacity-80">Total Roles</h2>
                <h1 class="text-4xl font-bold mt-2">{{ $totalRoles }}</h1>
            </div>

            <div class="bg-red-600 text-white p-6 rounded-2xl shadow-lg">
                <h2 class="text-sm font-medium opacity-80">Total Permissions</h2>
                <h1 class="text-4xl font-bold mt-2">{{ $totalPermissions }}</h1>
            </div>

            <div class="bg-purple-600 text-white p-6 rounded-2xl shadow-lg">
                <h2 class="text-sm font-medium opacity-80">Active Users</h2>
                <h1 class="text-4xl font-bold mt-2">{{ \App\Models\User::where('status', 'active')->count() }}</h1>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
                <h2 class="text-xl font-bold mb-4">👤 Logged-in User Info</h2>

                <div class="flex items-center gap-4 mb-4">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar"
                        class="w-16 h-16 rounded-full object-cover">
                    @else
                    <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    @endif

                    <div>
                        <p class="text-xl font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-gray-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <p class="mb-2">
                    <strong>Roles:</strong>
                    {{ auth()->user()->roles->pluck('name')->join(', ') ?: 'No roles assigned' }}
                </p>

                <p class="mb-2">
                    <strong>Status:</strong>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ auth()->user()->status == 'active' ? 'bg-green-600' : (auth()->user()->status == 'inactive' ? 'bg-yellow-600' : 'bg-red-600') }}">
                        {{ ucfirst(auth()->user()->status) }}
                    </span>
                </p>

                <p>
                    <strong>Is Admin:</strong>
                    {{ auth()->user()->hasRole('Admin') ? 'Yes' : 'No' }}
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
                <h2 class="text-xl font-bold mb-4">📊 Quick Stats</h2>

                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Inactive Users</span>
                        <span class="text-2xl font-bold text-yellow-400">
                            {{ \App\Models\User::where('status', 'inactive')->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Banned Users</span>
                        <span class="text-2xl font-bold text-red-400">
                            {{ \App\Models\User::where('status', 'banned')->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Deleted Users</span>
                        <span class="text-2xl font-bold text-gray-400">
                            {{ \App\Models\User::onlyTrashed()->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Total Logins</span>
                        <span class="text-2xl font-bold text-blue-400">
                            {{ \App\Models\LoginHistory::count() }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-8 bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-4">📋 Recent Activity</h2>

            <div class="space-y-3">
                @php
                $activities = \Spatie\Activitylog\Models\Activity::latest()->take(10)->get();
                @endphp

                @forelse($activities as $activity)
                <div class="flex items-center gap-4 bg-gray-800 rounded-xl p-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                        {{ substr($activity->causer?->name ?? 'S', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">
                            {{ $activity->causer?->name ?? 'System' }}
                            {{ $activity->description }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            {{ class_basename($activity->subject_type ?? '') }} #{{ $activity->subject_id ?? '' }}
                            - {{ $activity->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-center py-6">No recent activity</p>
                @endforelse
            </div>
        </div>

    </div>

</x-app-layout>
