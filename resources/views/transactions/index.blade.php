<x-app-layout>

    <div class="py-8">

        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-6 flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Transactions
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Track your income and expenses.
                    </p>
                </div>

                <a
                    href="{{ route('transactions.create') }}"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Add Transaction
                </a>

            </div>

            @if(session('success'))

            <div class="mb-5 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>

            @endif

            {{-- Filters --}}

            <form
                method="GET"
                action="{{ route('transactions.index') }}"
                class="mb-6 rounded-xl bg-white p-5 shadow">

                <div class="grid gap-4 md:grid-cols-4">

                    <div>
                        <label class="mb-1 block text-sm font-medium">
                            Type
                        </label>

                        <select
                            name="type"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                All
                            </option>

                            <option
                                value="income"
                                @selected(request('type')==='income' )>
                                Income
                            </option>

                            <option
                                value="expense"
                                @selected(request('type')==='expense' )>
                                Expense
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">
                            Category
                        </label>

                        <select
                            name="category_id"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                (string) request('category_id')===(string) $category->id
                                )
                                >
                                {{ $category->name }}
                            </option>

                            @endforeach

                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">
                            From
                        </label>

                        <input
                            type="date"
                            name="from_date"
                            value="{{ request('from_date') }}"
                            class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium">
                            To
                        </label>

                        <input
                            type="date"
                            name="to_date"
                            value="{{ request('to_date') }}"
                            class="w-full rounded-lg border-gray-300">
                    </div>

                </div>

                <div class="mt-4 flex gap-3">

                    <button
                        type="submit"
                        class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white">
                        Filter
                    </button>

                    <a
                        href="{{ route('transactions.index') }}"
                        class="rounded-lg border px-4 py-2 text-sm">
                        Reset
                    </a>

                </div>

            </form>

            {{-- Transactions --}}

            <div class="overflow-hidden rounded-xl bg-white shadow">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Date
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Title
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Category
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                Amount
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($transactions as $transaction)

                        <tr>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $transaction->title }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $transaction->category->name }}
                            </td>

                            <td class="px-6 py-4">

                                @if($transaction->type === 'income')

                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                    Income
                                </span>

                                @else

                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                    Expense
                                </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-right text-sm font-semibold">

                                ₹{{ number_format($transaction->amount, 2) }}

                            </td>

                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('transactions.edit', $transaction) }}"
                                    class="mr-3 text-sm font-medium text-indigo-600">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('transactions.destroy', $transaction) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Delete this transaction?')"
                                        class="text-sm font-medium text-red-600">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-10 text-center text-sm text-gray-500">
                                No transactions found.
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-5">
                {{ $transactions->links() }}
            </div>

        </div>

    </div>

</x-app-layout>