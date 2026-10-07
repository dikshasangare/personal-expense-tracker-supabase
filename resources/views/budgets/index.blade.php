<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Budgets
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your monthly spending limits.
                </p>
            </div>

            <a
                href="{{ route('budgets.create') }}"
                class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                + Add Budget
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
            @endif

            {{-- Error Messages --}}
            @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
                <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if ($budgets->count())

            {{-- Summary --}}
            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">
                        Total Budgets
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $budgets->count() }}
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">
                        Total Budget Amount
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        ₹{{ number_format($budgets->sum('amount'), 2) }}
                    </p>
                </div>

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-gray-500">
                        Current Month
                    </p>

                    <p class="mt-2 text-2xl font-bold text-gray-900">
                        {{ now()->format('F Y') }}
                    </p>
                </div>

            </div>

            {{-- Budget List --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">

                <div class="border-b border-gray-100 px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Your Budgets
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Monthly spending limits by category.
                    </p>
                </div>

                {{-- Desktop Table --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Category
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Period
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Budget Amount
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">

                            @foreach ($budgets as $budget)
                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-sm font-bold text-indigo-600">
                                            {{ strtoupper(substr($budget->category->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $budget->category->name }}
                                            </p>

                                            <p class="text-xs text-gray-500">
                                                Spending limit
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <span class="rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700">
                                        {{ \Carbon\Carbon::createFromDate($budget->year, $budget->month, 1)->format('F Y') }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <span class="text-base font-bold text-gray-900">
                                        ₹{{ number_format($budget->amount, 2) }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('budgets.edit', $budget) }}"
                                            class="rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-100">
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('budgets.destroy', $budget) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @foreach ($budgets as $budget)
                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 font-bold text-indigo-600">
                                    {{ strtoupper(substr($budget->category->name, 0, 1)) }}
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $budget->category->name }}
                                    </h4>

                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::createFromDate($budget->year, $budget->month, 1)->format('F Y') }}
                                    </p>
                                </div>

                            </div>

                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">
                                    ₹{{ number_format($budget->amount, 2) }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    Budget
                                </p>
                            </div>

                        </div>

                        <div class="mt-5 flex gap-2">

                            <a
                                href="{{ route('budgets.edit', $budget) }}"
                                class="flex-1 rounded-lg bg-indigo-50 px-3 py-2 text-center text-sm font-medium text-indigo-600 transition hover:bg-indigo-100">
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('budgets.destroy', $budget) }}"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </div>
                    @endforeach

                </div>

            </div>

            @else

            {{-- Empty State --}}
            <div class="rounded-2xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-gray-200">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-2xl">
                    💰
                </div>

                <h3 class="mt-5 text-lg font-semibold text-gray-900">
                    No budgets yet
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                    Create your first monthly budget to start controlling your spending by category.
                </p>

                <div class="mt-6">
                    <a
                        href="{{ route('budgets.create') }}"
                        class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        + Create Your First Budget
                    </a>
                </div>

            </div>

            @endif

        </div>
    </div>
</x-app-layout>