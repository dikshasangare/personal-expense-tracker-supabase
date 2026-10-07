<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ __('Dashboard') }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Overview of your personal finances
                </p>
            </div>

            <a
                href="{{ route('transactions.create') }}"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                + Add Transaction
            </a>
        </div>
    </x-slot>


    {{-- Page Content --}}
    <div class="py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))

            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>

            @endif


            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Total Income --}}
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                    <div class="p-6">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Total Income
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    ₹{{ number_format($totalIncome, 2) }}
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                <span class="text-xl text-green-600">
                                    ↑
                                </span>
                            </div>

                        </div>

                    </div>

                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-3">

                        <p class="text-xs text-gray-500">
                            All time income
                        </p>

                    </div>

                </div>


                {{-- Total Expense --}}
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                    <div class="p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm font-medium text-gray-500">
                                    Total Expense
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    ₹{{ number_format($totalExpense, 2) }}
                                </p>

                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">

                                <span class="text-xl text-red-600">
                                    ↓
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-3">

                        <p class="text-xs text-gray-500">
                            All time expenses
                        </p>

                    </div>

                </div>


                {{-- Balance --}}
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                    <div class="p-6">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm font-medium text-gray-500">
                                    Current Balance
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    ₹{{ number_format($balance, 2) }}
                                </p>

                            </div>

                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">

                                <span class="text-xl text-indigo-600">
                                    ₹
                                </span>

                            </div>

                        </div>

                    </div>

                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-3">

                        <p class="text-xs text-gray-500">
                            Income minus expenses
                        </p>

                    </div>

                </div>

            </div>


            {{-- Monthly Summary --}}
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Monthly Income --}}
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                {{ now()->format('F') }} Income
                            </p>

                            <p class="mt-2 text-2xl font-bold text-green-600">
                                ₹{{ number_format($currentMonthIncome, 2) }}
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            This month
                        </span>

                    </div>

                </div>


                {{-- Monthly Expense --}}
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                {{ now()->format('F') }} Expense
                            </p>

                            <p class="mt-2 text-2xl font-bold text-red-600">
                                ₹{{ number_format($currentMonthExpense, 2) }}
                            </p>

                        </div>

                        <span class="text-sm text-gray-400">
                            This month
                        </span>

                    </div>

                </div>

            </div>


            {{-- Main Content --}}
            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">


                {{-- Category Expenses --}}
                <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                    <div class="border-b border-gray-100 px-6 py-5">

                        <h3 class="text-lg font-semibold text-gray-900">
                            Category-wise Expenses
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Where your money is being spent
                        </p>

                    </div>


                    <div class="p-6">

                        @forelse($categoryExpenses as $item)

                        <div class="mb-5 last:mb-0">

                            <div class="mb-2 flex items-center justify-between">

                                <span class="text-sm font-medium text-gray-700">
                                    {{ $item->category->name }}
                                </span>

                                <span class="text-sm font-semibold text-gray-900">
                                    ₹{{ number_format($item->total, 2) }}
                                </span>

                            </div>

                            @php
                            $percentage = $totalExpense > 0
                            ? ($item->total / $totalExpense) * 100
                            : 0;
                            @endphp

                            <div class="h-2 overflow-hidden rounded-full bg-gray-100">

                                <div
                                    class="h-full rounded-full bg-indigo-500"
                                    style="width: {{ min($percentage, 100) }}%"></div>

                            </div>

                            <p class="mt-1 text-xs text-gray-400">
                                {{ number_format($percentage, 1) }}% of total expenses
                            </p>

                        </div>

                        @empty

                        <div class="py-8 text-center">

                            <p class="text-sm text-gray-500">
                                No expense data available.
                            </p>

                            <a
                                href="{{ route('transactions.create') }}"
                                class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                Add your first expense
                            </a>

                        </div>

                        @endforelse

                    </div>

                </div>


                {{-- Recent Transactions --}}
                <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-900">
                                Recent Transactions
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Your latest activity
                            </p>

                        </div>

                        <a
                            href="{{ route('transactions.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                            View all
                        </a>

                    </div>


                    <div class="divide-y divide-gray-100">

                        @forelse($recentTransactions as $transaction)

                        <div class="flex items-center justify-between px-6 py-4">

                            <div class="flex min-w-0 items-center gap-4">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                        {{ $transaction->type === 'income'
                                            ? 'bg-green-100'
                                            : 'bg-red-100'
                                        }}">

                                    <span
                                        class="
                                                {{ $transaction->type === 'income'
                                                    ? 'text-green-600'
                                                    : 'text-red-600'
                                                }}
                                            ">
                                        {{ $transaction->type === 'income' ? '+' : '−' }}
                                    </span>

                                </div>


                                <div class="min-w-0">

                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ $transaction->title }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $transaction->category->name }}
                                        ·
                                        {{ $transaction->transaction_date->format('d M Y') }}
                                    </p>

                                </div>

                            </div>


                            <div class="ml-4 shrink-0 text-right">

                                <p
                                    class="text-sm font-semibold
                                            {{ $transaction->type === 'income'
                                                ? 'text-green-600'
                                                : 'text-red-600'
                                            }}">

                                    {{ $transaction->type === 'income' ? '+' : '-' }}
                                    ₹{{ number_format($transaction->amount, 2) }}

                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ ucfirst($transaction->payment_method ?? 'Other') }}
                                </p>

                            </div>

                        </div>

                        @empty

                        <div class="px-6 py-10 text-center">

                            <p class="text-sm text-gray-500">
                                No transactions yet.
                            </p>

                            <a
                                href="{{ route('transactions.create') }}"
                                class="mt-3 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                Add your first transaction
                            </a>

                        </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="mt-6 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                <h3 class="text-lg font-semibold text-gray-900">
                    Quick Actions
                </h3>

                <div class="mt-4 flex flex-wrap gap-3">

                    <a
                        href="{{ route('transactions.create') }}"
                        class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">
                        Add Transaction
                    </a>

                    <a
                        href="{{ route('categories.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Manage Categories
                    </a>

                    <a
                        href="{{ route('transactions.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        View Transactions
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>