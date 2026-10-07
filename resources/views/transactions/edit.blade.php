<x-app-layout>

    <div class="py-8">

        <div class="mx-auto max-w-2xl px-6">

            {{-- Page Header --}}

            <div class="mb-6">

                <h1 class="text-2xl font-bold text-gray-900">
                    Edit Transaction
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Update your income or expense transaction.
                </p>

            </div>

            {{-- Form --}}

            <form
                method="POST"
                action="{{ route('transactions.update', $transaction) }}"
                class="rounded-xl bg-white p-6 shadow">

                @csrf
                @method('PUT')

                <div class="space-y-5">

                    {{-- Type --}}

                    <div>

                        <label
                            for="type"
                            class="mb-2 block text-sm font-medium text-gray-700">
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
                                @selected(
                                old('type', $transaction->type) === 'expense'
                                )
                                >
                                Expense
                            </option>

                            <option
                                value="income"
                                @selected(
                                old('type', $transaction->type) === 'income'
                                )
                                >
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

                        <label
                            for="category_id"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Category
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select category
                            </option>

                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                old( 'category_id' ,
                                $transaction->category_id
                                ) == $category->id
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

                        <label
                            for="amount"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Amount
                        </label>

                        <input
                            type="number"
                            name="amount"
                            id="amount"
                            step="0.01"
                            min="0.01"
                            value="{{ old('amount', $transaction->amount) }}"
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

                        <label
                            for="title"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $transaction->title) }}"
                            placeholder="e.g. Lunch"
                            class="w-full rounded-lg border-gray-300">

                        @error('title')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Transaction Date --}}

                    <div>

                        <label
                            for="transaction_date"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Transaction Date
                        </label>

                        <input
                            type="date"
                            name="transaction_date"
                            id="transaction_date"
                            value="{{ old(
                                'transaction_date',
                                $transaction->transaction_date->format('Y-m-d')
                            ) }}"
                            class="w-full rounded-lg border-gray-300">

                        @error('transaction_date')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Payment Method --}}

                    <div>

                        <label
                            for="payment_method"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Payment Method
                        </label>

                        <select
                            name="payment_method"
                            id="payment_method"
                            class="w-full rounded-lg border-gray-300">

                            <option value="">
                                Select payment method
                            </option>

                            <option
                                value="cash"
                                @selected(
                                old( 'payment_method' ,
                                $transaction->payment_method
                                ) === 'cash'
                                )
                                >
                                Cash
                            </option>

                            <option
                                value="upi"
                                @selected(
                                old( 'payment_method' ,
                                $transaction->payment_method
                                ) === 'upi'
                                )
                                >
                                UPI
                            </option>

                            <option
                                value="card"
                                @selected(
                                old( 'payment_method' ,
                                $transaction->payment_method
                                ) === 'card'
                                )
                                >
                                Card
                            </option>

                            <option
                                value="bank_transfer"
                                @selected(
                                old( 'payment_method' ,
                                $transaction->payment_method
                                ) === 'bank_transfer'
                                )
                                >
                                Bank Transfer
                            </option>

                            <option
                                value="other"
                                @selected(
                                old( 'payment_method' ,
                                $transaction->payment_method
                                ) === 'other'
                                )
                                >
                                Other
                            </option>

                        </select>

                        @error('payment_method')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Description --}}

                    <div>

                        <label
                            for="description"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Optional description">{{ old('description', $transaction->description) }}</textarea>

                        @error('description')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Notes --}}

                    <div>

                        <label
                            for="notes"
                            class="mb-2 block text-sm font-medium text-gray-700">
                            Notes
                        </label>

                        <textarea
                            name="notes"
                            id="notes"
                            rows="3"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Optional notes">{{ old('notes', $transaction->notes) }}</textarea>

                        @error('notes')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>

                </div>


                {{-- Buttons --}}

                <div class="mt-6 flex justify-end gap-3">

                    <a
                        href="{{ route('transactions.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Update Transaction
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>