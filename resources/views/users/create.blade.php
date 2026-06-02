<x-app-layout>

    <div class="min-h-[80vh] flex items-center justify-center px-4">

        <div class="w-full max-w-lg bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl p-8">

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-white">
                    👤 Create User
                </h1>

                <p class="text-gray-400 mt-2">
                    Add a new user to the system
                </p>

            </div>

            <form method="POST" action="{{ route('users.store') }}">

                @csrf

                <div class="mb-5">
                    <label class="block text-gray-300 mb-2">
                        Name
                    </label>

                    <input type="text" name="name" placeholder="Enter Name"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-300 mb-2">
                        Email
                    </label>

                    <input type="email" name="email" placeholder="Enter Email"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-300 mb-2">
                        Password
                    </label>

                    <input type="password" name="password" placeholder="Enter Password"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-300 mb-2">
                        Role
                    </label>

                    <select name="role_id"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        @foreach($roles as $role)

                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <button
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold transition">

                    Save User

                </button>

            </form>

        </div>

    </div>

</x-app-layout>