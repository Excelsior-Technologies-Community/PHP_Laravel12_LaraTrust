<x-app-layout>

    <div class="min-h-[80vh] flex items-center justify-center px-4">

        <div class="w-full max-w-lg bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl p-8">

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-white">
                    ✏️ Edit User
                </h1>

                <p class="text-gray-400 mt-2">
                    Update user information
                </p>

            </div>

            <form method="POST" action="{{ route('users.update', $user) }}">

                @csrf
                @method('PUT')

                <div class="mb-5">

                    <label class="block text-gray-300 mb-2">
                        Name
                    </label>

                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                </div>

                <div class="mb-6">

                    <label class="block text-gray-300 mb-2">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ $user->email }}"
                        class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                </div>

                <button
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition">

                    Update User

                </button>

            </form>

        </div>

    </div>

</x-app-layout>