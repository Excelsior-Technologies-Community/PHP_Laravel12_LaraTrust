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

                    <a href="{{ route('users.trashed') }}"
                        class="bg-gray-600 hover:bg-gray-700 px-5 py-3 rounded-xl font-semibold shadow-md transition">
                        🗑 Trashed
                    </a>

                </div>

            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-8 shadow-lg">

                <form method="GET"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

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

                    <div>
                        <label class="text-sm text-gray-400">Status</label>
                        <select name="status" class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-400">Role</label>
                        <select name="role" class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-3">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 md:col-span-5">
                        <button class="flex-1 bg-blue-600 hover:bg-blue-700 px-4 py-3 rounded-xl font-semibold transition">
                            Filter
                        </button>

                        <a href="{{ route('users.index') }}"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 px-4 py-3 rounded-xl text-center font-semibold transition">
                            Reset
                        </a>
                    </div>

                </form>

            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">👥 Users List</h2>

                    <div class="flex gap-2">
                        <select id="bulk-status" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm">
                            <option value="">Change Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="banned">Banned</option>
                        </select>

                        <button onclick="bulkStatusUpdate()"
                            class="bg-yellow-600 hover:bg-yellow-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Apply
                        </button>

                        <button onclick="bulkDelete()"
                            class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Delete Selected
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">

                    <form id="bulk-form">
                        @csrf

                        <table class="w-full text-left">

                            <thead class="bg-gray-800 text-gray-300 text-sm">
                                <tr>
                                    <th class="px-6 py-4 w-10">
                                        <input type="checkbox" id="select-all" onclick="toggleSelectAll()">
                                    </th>
                                    <th class="px-6 py-4">Avatar</th>
                                    <th class="px-6 py-4">Name</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Roles</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800">

                                @forelse($users as $user)

                                <tr class="hover:bg-gray-800/50 transition" id="user-row-{{ $user->id }}">

                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox">
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="Avatar"
                                            class="w-10 h-10 rounded-full object-cover">
                                        @else
                                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 font-medium">
                                        {{ $user->name }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($user->status == 'active')
                                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                            Active
                                        </span>
                                        @elseif($user->status == 'inactive')
                                        <span class="bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                            Inactive
                                        </span>
                                        @else
                                        <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                                            Banned
                                        </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-gray-400">
                                        {{ $user->roles->pluck('name')->join(', ') ?: '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('users.edit', $user) }}"
                                                class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Edit
                                            </a>

                                            <button onclick="deleteUser({{ $user->id }})"
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Delete
                                            </button>

                                        </div>
                                    </td>

                                </tr>

                                @empty

                                <tr>
                                    <td colspan="7" class="text-center py-10 text-gray-400">
                                        No Users Found
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </form>

                </div>

            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>

    </div>

    <script>
        function toggleSelectAll() {
            document.querySelectorAll('.user-checkbox').forEach(cb => {
                cb.checked = document.getElementById('select-all').checked;
            });
        }

        function deleteUser(id) {
            if (!confirm('Delete this user?')) return;

            fetch(`/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`user-row-${id}`).remove();
                        alert(data.message);
                    }
                });
        }

        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkboxes.length === 0) return alert('Please select users');

            if (!confirm(`Delete ${checkboxes.length} users?`)) return;

            const formData = new FormData(document.getElementById('bulk-form'));

            fetch('/users/bulk-destroy', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        function bulkStatusUpdate() {
            const checkboxes = document.querySelectorAll('.user-checkbox:checked');
            const status = document.getElementById('bulk-status').value;

            if (checkboxes.length === 0) return alert('Please select users');
            if (!status) return alert('Please select a status');

            const formData = new FormData(document.getElementById('bulk-form'));
            formData.append('status', status);

            fetch('/users/bulk-status', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }
    </script>

</x-app-layout>
