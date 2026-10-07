<x-app-layout>

    <div class="py-8">

        <div class="mx-auto max-w-2xl px-6">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    Add Transaction
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Record your income or expense.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('transactions.store') }}"
                class="rounded-xl bg-white p-6 shadow">

                @csrf

                <div class="space-y-5">

                    {{-- Type --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Type
                        </label>

                        <select
                            name="type"
                            id="type"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select type
                            </option>

                            <option
                                value="expense"
                                @selected(old('type')==='expense' )>
                                Expense
                            </option>

                            <option
                                value="income"
                                @selected(old('type')==='income' )>
                                Income
                            </option>

                        </select>

                        @error('type')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- Category --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Category
                        </label>

                        <select
                            name="category_id"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select category
                            </option>

                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                old('category_id')==$category->id
                                )
                                >
                                {{ $category->name }}
                                ({{ ucfirst($category->type) }})
                            </option>

                            @endforeach

                        </select>

                        @error('category_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- Amount --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Amount
                        </label>

                        <input
                            type="number"
                            name="amount"
                            step="0.01"
                            min="0.01"
                            value="{{ old('amount') }}"
                            placeholder="0.00"
                            class="w-full rounded-lg border-gray-300">

                        @error('amount')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- Title --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="e.g. Lunch"
                            class="w-full rounded-lg border-gray-300">

                        @error('title')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- Date --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Transaction Date
                        </label>

                        <input
                            type="date"
                            name="transaction_date"
                            value="{{ old('transaction_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300">

                        @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- Payment Method --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Payment Method
                        </label>

                        <select
                            name="payment_method"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select payment method
                            </option>

                            <option value="cash">
                                Cash
                            </option>

                            <option value="upi">
                                UPI
                            </option>

                            <option value="card">
                                Card
                            </option>

                            <option value="bank_transfer">
                                Bank Transfer
                            </option>

                            <option value="other">
                                Other
                            </option>

                        </select>

                    </div>

                    {{-- Description --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="3"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Optional description">{{ old('description') }}</textarea>

                    </div>

                    {{-- Notes --}}

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            rows="3"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Optional notes">{{ old('notes') }}</textarea>

                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">

                    <a
                        href="{{ route('transactions.index') }}"
                        class="rounded-lg border px-4 py-2 text-sm">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white">
                        Save Transaction
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>