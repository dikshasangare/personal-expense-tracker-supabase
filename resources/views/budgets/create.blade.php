<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Add Budget
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Set a spending limit for a category.
                </p>
            </div>

            <a href="{{ route('budgets.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50">
                ← Back to Budgets
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <div class="font-medium text-red-800">
                    Please fix the following errors:
                </div>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

                <div class="border-b border-gray-100 px-6 py-5 sm:px-8">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Budget Information
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Choose a category and define how much you want to spend.
                    </p>
                </div>

                <form method="POST" action="{{ route('budgets.store') }}" class="space-y-6 px-6 py-7 sm:px-8">
                    @csrf

                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">
                            Category
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            required
                            class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select category</option>

                            @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label for="amount" class="mb-2 block text-sm font-medium text-gray-700">
                            Budget Amount
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                                ₹
                            </span>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                value="{{ old('amount') }}"
                                min="0.01"
                                step="0.01"
                                required
                                placeholder="5000.00"
                                class="block w-full rounded-xl border-gray-300 py-3 pl-9 pr-4 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Month + Year --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <label for="month" class="mb-2 block text-sm font-medium text-gray-700">
                                Month
                            </label>

                            <select
                                id="month"
                                name="month"
                                required
                                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select month</option>

                                @foreach ([
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                                ] as $number => $name)
                                <option
                                    value="{{ $number }}"
                                    {{ old('month', now()->month) == $number ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                                @endforeach
                            </select>

                            @error('month')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="mb-2 block text-sm font-medium text-gray-700">
                                Year
                            </label>

                            <input
                                type="number"
                                id="year"
                                name="year"
                                value="{{ old('year', now()->year) }}"
                                min="2020"
                                max="2100"
                                required
                                class="block w-full rounded-xl border-gray-300 px-4 py-3 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            @error('year')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">

                        <a
                            href="{{ route('budgets.index') }}"
                            class="rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save Budget
                        </button>

                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>