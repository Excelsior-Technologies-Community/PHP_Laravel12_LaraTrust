<x-app-layout>

    <div class="min-h-screen bg-gray-950 text-white py-10">

        <div class="max-w-3xl mx-auto px-6">

            <div class="mb-8">
                <a href="{{ route('permissions.index') }}"
                    class="text-gray-400 hover:text-white transition">&larr; Back to Permissions</a>

                <h1 class="text-4xl font-bold mt-4">✏️ Edit Permission</h1>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 shadow-xl">

                <form method="POST" action="{{ route('permissions.update', $permission) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $permission->name) }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Display Name</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $permission->display_name) }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        @error('display_name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $permission->description) }}</textarea>
                        @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-xl font-semibold transition">
                            Update Permission
                        </button>

                        <a href="{{ route('permissions.index') }}"
                            class="flex-1 bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-xl text-center font-semibold transition">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
