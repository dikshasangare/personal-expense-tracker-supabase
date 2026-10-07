<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()
            ->transactions()
            ->with('category');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate(
                'transaction_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {
            $query->whereDate(
                'transaction_date',
                '<=',
                $request->to_date
            );
        }

        $transactions = $query
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view(
            'transactions.index',
            compact('transactions', 'categories')
        );
    }

    public function create()
    {
        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view(
            'transactions.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:50',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $category = auth()->user()
            ->categories()
            ->findOrFail($validated['category_id']);

        if ($category->type !== $validated['type']) {
            return back()
                ->withErrors([
                    'category_id' =>
                    'Selected category does not match transaction type.',
                ])
                ->withInput();
        }

        auth()->user()
            ->transactions()
            ->create($validated);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction created successfully.'
            );
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view(
            'transactions.edit',
            compact('transaction', 'categories')
        );
    }

    public function update(
        Request $request,
        Transaction $transaction
    ) {
        $this->authorizeTransaction($transaction);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'type' => [
                'required',
                'in:income,expense',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:50',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $category = auth()->user()
            ->categories()
            ->findOrFail($validated['category_id']);

        if ($category->type !== $validated['type']) {
            return back()
                ->withErrors([
                    'category_id' =>
                    'Selected category does not match transaction type.',
                ])
                ->withInput();
        }

        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction updated successfully.'
            );
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with(
                'success',
                'Transaction deleted successfully.'
            );
    }

    private function authorizeTransaction(
        Transaction $transaction
    ): void {
        abort_unless(
            $transaction->user_id === auth()->id(),
            403
        );
    }
}
