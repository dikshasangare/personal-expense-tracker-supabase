<x-app-layout>

    <div class="py-8">
        <div class="mx-auto max-w-2xl px-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Add Category
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Create a new income or expense category.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('categories.store') }}"
                class="rounded-xl bg-white p-6 shadow">

                @csrf

                <div class="space-y-5">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Food"
                            class="w-full rounded-lg border-gray-300">

                        @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Type
                        </label>

                        <select
                            name="type"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select type
                            </option>

                            <option value="expense">
                                Expense
                            </option>

                            <option value="income">
                                Income
                            </option>

                        </select>

                        @error('type')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Icon
                        </label>

                        <input
                            type="text"
                            name="icon"
                            value="{{ old('icon') }}"
                            placeholder="Optional"
                            class="w-full rounded-lg border-gray-300">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <a
                        href="{{ route('categories.index') }}"
                        class="rounded-lg border px-4 py-2 text-sm">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">
                        Create Category
                    </button>

                </div>

            </form>

        </div>
    </div>

</x-app-layout>