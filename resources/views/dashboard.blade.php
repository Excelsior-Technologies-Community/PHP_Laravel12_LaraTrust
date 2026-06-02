<x-app-layout>

<div class="max-w-7xl mx-auto p-6">

    <div class="grid grid-cols-3 gap-4">

        <div class="bg-blue-500 text-white p-5 rounded">

            <h2>Total Users</h2>

            <h1 class="text-3xl">
                {{ $totalUsers }}
            </h1>

        </div>

        <div class="bg-green-500 text-white p-5 rounded">

            <h2>Total Roles</h2>

            <h1 class="text-3xl">
                {{ $totalRoles }}
            </h1>

        </div>

        <div class="bg-red-500 text-white p-5 rounded">

            <h2>Total Permissions</h2>

            <h1 class="text-3xl">
                {{ $totalPermissions }}
            </h1>

        </div>

    </div>

</div>

</x-app-layout>