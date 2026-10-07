<x-app-layout>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-6 flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Categories
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage your income and expense categories.
                    </p>
                </div>

                <a
                    href="{{ route('categories.create') }}"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Add Category
                </a>

            </div>

            @if(session('success'))

            <div class="mb-5 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>

            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Name
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($categories as $category)

                        <tr>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-4">

                                @if($category->type === 'income')

                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Income
                                </span>

                                @else

                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    Expense
                                </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('categories.edit', $category) }}"
                                    class="mr-3 text-sm font-medium text-indigo-600">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('categories.destroy', $category) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Delete this category?')"
                                        class="text-sm font-medium text-red-600">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="3"
                                class="px-6 py-10 text-center text-sm text-gray-500">
                                No categories found.
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>