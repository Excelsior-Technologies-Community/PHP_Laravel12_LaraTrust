<x-app-layout>

<div class="max-w-7xl mx-auto p-6">

    <div class="grid grid-cols-3 gap-4">

        <div class="bg-blue-500 text-white p-5 rounded">
            <h2>Total Users</h2>
            <h1 class="text-3xl">{{ $totalUsers }}</h1>
        </div>

        <div class="bg-green-500 text-white p-5 rounded">
            <h2>Total Roles</h2>
            <h1 class="text-3xl">{{ $totalRoles }}</h1>
        </div>

        <div class="bg-red-500 text-white p-5 rounded">
            <h2>Total Permissions</h2>
            <h1 class="text-3xl">{{ $totalPermissions }}</h1>
        </div>

    </div>

    {{-- USER ROLE INFO (ADDED HERE) --}}
    <div class="mt-8 bg-gray-900 text-white p-6 rounded-xl">

        <h2 class="text-xl font-bold mb-4">👤 Logged-in User Info</h2>

        <p class="mb-2">
            <strong>Name:</strong> {{ auth()->user()->name }}
        </p>

        <p class="mb-2">
            <strong>Email:</strong> {{ auth()->user()->email }}
        </p>

        <p class="mb-2">
            <strong>Roles:</strong>
            {{ auth()->user()->roles->pluck('name')->join(', ') }}
        </p>

        <p>
            <strong>Is Admin:</strong>
            {{ auth()->user()->hasRole('Admin') ? 'Yes' : 'No' }}
        </p>

    </div>

</div>

</x-app-layout>