<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = auth()->user()
            ->budgets()
            ->with('category')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('budgets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'month' => [
                'required',
                'integer',
                'between:1,12',
            ],
            'year' => [
                'required',
                'integer',
                'between:2020,2100',
            ],
        ]);

        $category = auth()->user()
            ->categories()
            ->findOrFail($validated['category_id']);

        $existingBudget = auth()->user()
            ->budgets()
            ->where('category_id', $category->id)
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($existingBudget) {
            return back()
                ->withInput()
                ->withErrors([
                    'category_id' => 'A budget already exists for this category and month.',
                ]);
        }

        auth()->user()->budgets()->create($validated);

        return redirect()
            ->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    public function edit(Budget $budget)
    {
        $this->authorizeBudget($budget);

        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorizeBudget($budget);

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'month' => [
                'required',
                'integer',
                'between:1,12',
            ],
            'year' => [
                'required',
                'integer',
                'between:2020,2100',
            ],
        ]);

        $category = auth()->user()
            ->categories()
            ->findOrFail($validated['category_id']);

        $existingBudget = auth()->user()
            ->budgets()
            ->where('category_id', $category->id)
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($existingBudget) {
            return back()
                ->withInput()
                ->withErrors([
                    'category_id' => 'A budget already exists for this category and month.',
                ]);
        }

        $budget->update($validated);

        return redirect()
            ->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorizeBudget($budget);

        $budget->delete();

        return redirect()
            ->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }

    private function authorizeBudget(Budget $budget)
    {
        abort_unless(
            $budget->user_id === Auth::id(),
            403
        );
    }
}
