<x-guest-layout>
    @php
    // Example backend data structure matching your React component
    $transactions = $transactions ?? [
    ['id' => 1, 'vendor' => 'Starbucks', 'category' => 'Dining', 'amount' => 12.50, 'date' => '2026-09-04', 'tags' => ['Coffee']],
    ['id' => 2, 'vendor' => 'Uber', 'category' => 'Transport', 'amount' => 24.80, 'date' => '2026-09-03', 'tags' => ['Commute']],
    ['id' => 3, 'vendor' => 'Whole Foods', 'category' => 'Groceries', 'amount' => 115.20, 'date' => '2026-09-02', 'tags' => ['Weekly']],
    ['id' => 4, 'vendor' => 'Uniqlo', 'category' => 'Shopping', 'amount' => 89.00, 'date' => '2026-09-01', 'tags' => []],
    ['id' => 5, 'vendor' => 'AMC Theatres', 'category' => 'Entertainment', 'amount' => 32.00, 'date' => '2026-08-30', 'tags' => ['Movies']],
    ];

    $categories = ['Dining', 'Transport', 'Shopping', 'Groceries', 'Entertainment'];

    // Category background and text styling maps
    $categoryTones = [
    'Dining' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
    'Transport' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950 dark:text-cyan-300',
    'Shopping' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
    'Groceries' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
    'Entertainment' => 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300',
    'Other' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
    ];

    $categorySwatches = [
    'Dining' => '#6b8e23',
    'Transport' => '#5f9ea0',
    'Shopping' => '#d2691e',
    'Groceries' => '#e9d66b',
    'Entertainment' => '#db7093',
    ];

    // Compute category spent totals
    $spentByCategory = [];
    foreach ($transactions as $t) {
    $cat = $t['category'] ?? 'Other';
    $spentByCategory[$cat] = ($spentByCategory[$cat] ?? 0) + (float) $t['amount'];
    }

    $totalSpent = array_sum($spentByCategory);

    // Initial budget mock data
    $budgets = $budgets ?? [
    'Dining' => 300,
    'Transport' => 150,
    'Shopping' => 200,
    'Groceries' => 450,
    'Entertainment' => 100,
    ];

    $totalLimit = array_sum($budgets);
    @endphp

    <div x-data="{
        activeTab: 'Dashboard',
        navItems: ['Dashboard', 'Expenses', 'Insights'],
        promptValue: '',
        editingBudget: false,
        budgets: {{ json_encode($budgets) }},
        draftBudgets: {{ json_encode($budgets) }},
        spent: {{ json_encode($spentByCategory) }},
        saveBudgets() {
            this.budgets = { ...this.draftBudgets };
            this.editingBudget = false;
            // Optional: Perform fetch/axios POST call to sync budget updates here
        },
        cancelBudgetEdit() {
            this.draftBudgets = { ...this.budgets };
            this.editingBudget = false;
        },
        get totalLimitValue() {
            return Object.values(this.budgets).reduce((a, b) => Number(a) + Number(b), 0);
        }
    }" className="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">

        <!-- Header Navigation -->
        <header className="sticky top-0 z-30 border-b border-slate-200/80 bg-white/80 backdrop-blur-md dark:border-slate-800/80 dark:bg-slate-900/80">
            <div className="mx-auto flex h-16 max-w-[1400px] items-center gap-6 px-6 lg:px-10">
                <!-- Logo -->
                <div className="flex items-center gap-2.5">
                    <div className="flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-sm dark:bg-slate-100 dark:text-slate-900">
                        <span className="text-[15px] font-semibold tracking-tight">B</span>
                    </div>
                    <div className="leading-none">
                        <p className="text-[15px] font-semibold tracking-tight">BAS24</p>
                        <p className="text-[10px] font-medium uppercase tracking-[0.2em] text-slate-500">AI</p>
                    </div>
                </div>

                <!-- Nav Tabs -->
                <nav className="ml-2 hidden items-center gap-1 md:flex">
                    <template x-for="item in navItems" :key="item">
                        <button
                            @click="activeTab = item"
                            :class="activeTab === item ? 'bg-slate-200/70 text-slate-900 dark:bg-slate-800 dark:text-slate-100' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800/60 dark:hover:text-slate-100'"
                            className="relative rounded-full px-4 py-2 text-sm font-medium transition-all"
                            x-text="item">
                        </button>
                    </template>
                </nav>

                <!-- Search Bar -->
                <div className="ml-auto hidden max-w-xs flex-1 items-center gap-2 rounded-full border border-slate-200 bg-white/70 px-4 py-2 text-sm text-slate-500 shadow-sm dark:border-slate-800 dark:bg-slate-900/70 lg:flex">
                    <svg className="h-4 w-4 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input
                        type="text"
                        placeholder="Search transactions…"
                        className="w-full bg-transparent text-slate-900 placeholder:text-slate-400 focus:outline-none dark:text-slate-100" />
                    <kbd className="hidden rounded-md border border-slate-200 bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-500 dark:border-slate-800 dark:bg-slate-800 lg:inline">⌘K</kbd>
                </div>

                <!-- Actions -->
                <div className="ml-auto flex items-center gap-3 lg:ml-0">
                    <button className="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-slate-100">
                        <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                        </svg>
                    </button>
                    <button className="hidden items-center gap-1.5 rounded-full bg-slate-900 px-3.5 py-2 text-sm font-medium text-white shadow-sm transition hover:opacity-90 dark:bg-slate-100 dark:text-slate-900 sm:flex">
                        <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                        Add
                    </button>
                    <button className="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full ring-2 ring-slate-200 shadow-sm dark:ring-slate-800">
                        <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-emerald-200 to-teal-400 text-xs font-semibold text-teal-950">
                            SK
                        </div>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main className="mx-auto max-w-[1400px] px-6 py-8 lg:px-10 lg:py-10">
            <!-- Hero Banner -->
            <section className="relative mb-6 overflow-hidden rounded-[32px] border border-slate-200/60 bg-gradient-to-br from-emerald-500/10 via-white to-slate-50 p-7 shadow-sm dark:border-slate-800/60 dark:via-slate-900 dark:to-slate-950 lg:p-9">
                <div className="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full bg-emerald-500/15 blur-3xl"></div>
                <div className="pointer-events-none absolute -bottom-24 left-1/3 h-48 w-48 rounded-full bg-teal-500/20 blur-3xl"></div>

                <div className="relative flex flex-col gap-7 lg:flex-row lg:items-center lg:justify-between">
                    <div className="max-w-2xl">
                        <p className="text-sm font-medium text-slate-500">{{ now()->format('l, F j') }}</p>
                        <h1 className="mt-1 text-3xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 lg:text-[40px]">
                            Welcome back, Sarah 👋
                        </h1>
                        <p className="mt-1.5 text-[15px] text-slate-500">
                            Here's a calm look at your money this month.
                        </p>

                        <!-- AI Input Bar -->
                        <div className="mt-5">
                            <div className="relative">
                                <div className="group flex items-center gap-3 rounded-3xl border border-slate-200 bg-white/80 px-5 py-4 shadow-sm backdrop-blur-xl transition focus-within:border-emerald-500/40 dark:border-slate-800 dark:bg-slate-900/80">
                                    <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                        <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m12 3-1.9 5.8a2 2 0 0 1-1.28 1.28L3 12l5.8 1.9a2 2 0 0 1 1.28 1.28L12 21l1.9-5.8a2 2 0 0 1 1.28-1.28L21 12l-5.8-1.9a2 2 0 0 1-1.28-1.28Z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        x-model="promptValue"
                                        placeholder="Ask BAS24 AI: “How much did I spend at Starbucks last month?” or drag & drop receipts here…"
                                        className="w-full bg-transparent text-[15px] text-slate-900 placeholder:text-slate-400 focus:outline-none dark:text-slate-100" />
                                    <button className="hidden items-center gap-1.5 rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:text-slate-900 dark:border-slate-800 dark:hover:text-slate-100 sm:flex">
                                        <svg className="h-3.5 w-3.5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                        </svg>
                                        Receipt
                                    </button>
                                    <button className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-900 text-white shadow-sm transition hover:opacity-90 dark:bg-slate-100 dark:text-slate-900">
                                        <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="m12 5 7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p className="mt-2.5 pl-2 text-xs text-slate-500">
                                    Try: “Show my dining trend” · “Budget for groceries” · “Categorize last receipt”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Monthly Total -->
                    <div className="shrink-0 rounded-[26px] border border-slate-200/50 bg-white/70 px-7 py-6 shadow-sm backdrop-blur-xl dark:border-slate-800/50 dark:bg-slate-900/70 lg:w-[300px]">
                        <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">
                            Spent this month
                        </p>
                        <p className="mt-1.5 text-[44px] font-semibold leading-none tracking-tight tabular-nums text-slate-900 dark:text-slate-100">
                            ${{ number_format($totalSpent, 0) }}
                        </p>
                        <div className="mt-3 flex items-center gap-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                            <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
                                <polyline points="16 17 22 17 22 11"></polyline>
                            </svg>
                            12% less than last month
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stat Pills Grid -->
            <section className="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
                <!-- Stat 1 -->
                <div className="rounded-3xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/60">
                    <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Spent this month</p>
                    <div className="mt-2 flex items-end justify-between">
                        <p className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">${{ number_format($totalSpent, 0) }}</p>
                        <span className="inline-flex items-center gap-0.5 rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            <svg className="h-3 w-3 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
                                <polyline points="16 17 22 17 22 11"></polyline>
                            </svg>
                            12%
                        </span>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div className="rounded-3xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/60">
                    <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Avg / day</p>
                    <div className="mt-2 flex items-end justify-between">
                        <p className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">${{ number_format(round($totalSpent / 30), 0) }}</p>
                        <span className="inline-flex items-center gap-0.5 rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            <svg className="h-3 w-3 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
                                <polyline points="16 17 22 17 22 11"></polyline>
                            </svg>
                            8%
                        </span>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div className="rounded-3xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/60">
                    <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Top category</p>
                    <div className="mt-2 flex items-end justify-between">
                        <p className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                            {{ !empty($spentByCategory) ? array_search(max($spentByCategory), $spentByCategory) : '—' }}
                        </p>
                        <span className="inline-flex items-center gap-0.5 rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                            Stable
                        </span>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div className="rounded-3xl border border-slate-200/70 bg-white/60 p-5 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/60">
                    <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Budget left</p>
                    <div className="mt-2 flex items-end justify-between">
                        <p className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                            $<span x-text="(totalLimitValue - {{ $totalSpent }}).toLocaleString()">{{ number_format($totalLimit - $totalSpent, 0) }}</span>
                        </p>
                        <span className="inline-flex items-center gap-0.5 rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                            <svg className="h-3 w-3 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                <polyline points="16 7 22 7 22 13"></polyline>
                            </svg>
                            6%
                        </span>
                    </div>
                </div>
            </section>

            <!-- Dashboard Bento Grid -->
            <section className="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <!-- Left Column: Insights & Activity -->
                <div className="flex flex-col gap-6 lg:col-span-8">
                    <!-- AI Insight Card -->
                    <div className="relative overflow-hidden rounded-[28px] border border-emerald-500/20 bg-gradient-to-br from-emerald-500/10 via-white to-white p-7 shadow-sm dark:via-slate-900 dark:to-slate-900">
                        <div className="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-emerald-500/10 blur-2xl"></div>
                        <div className="relative flex items-start gap-4">
                            <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-sm dark:bg-slate-100 dark:text-slate-900">
                                <svg className="h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m12 3-1.9 5.8a2 2 0 0 1-1.28 1.28L3 12l5.8 1.9a2 2 0 0 1 1.28 1.28L12 21l1.9-5.8a2 2 0 0 1 1.28-1.28L21 12l-5.8-1.9a2 2 0 0 1-1.28-1.28Z"></path>
                                </svg>
                            </div>
                            <div className="flex-1">
                                <div className="flex items-center gap-2">
                                    <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-emerald-800 dark:text-emerald-300">AI Insight</p>
                                    <span className="inline-flex items-center gap-1 rounded-full bg-emerald-500/15 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-300">
                                        <svg className="h-3 w-3 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
                                            <polyline points="16 17 22 17 22 11"></polyline>
                                        </svg>
                                        15% less
                                    </span>
                                </div>
                                <p className="mt-2 text-[17px] font-medium leading-snug text-slate-900 dark:text-slate-100">
                                    You're spending <span className="text-emerald-600 dark:text-emerald-400">15% less</span> on dining out this week. Keep it up!
                                </p>
                                <p className="mt-1.5 text-sm text-slate-500">
                                    Compared to your 4-week average. That's about $48 saved.
                                </p>
                                <button className="mt-4 inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600 transition hover:gap-2 dark:text-emerald-400">
                                    See full breakdown
                                    <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="7" y1="17" x2="17" y2="7"></line>
                                        <polyline points="7 7 17 7 17 17"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Feed -->
                    <div className="rounded-[28px] border border-slate-200/70 bg-white/70 p-7 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/70">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Recent activity</p>
                                <h3 className="mt-1 text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100">Latest transactions</h3>
                            </div>
                            <button className="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:text-slate-900 dark:border-slate-800 dark:hover:text-slate-100">
                                See all
                            </button>
                        </div>

                        <ul className="mt-5 space-y-1.5">
                            @foreach ($transactions as $t)
                            @php
                            $category = $t['category'] ?? 'Other';
                            $tone = $categoryTones[$category] ?? $categoryTones['Other'];
                            @endphp
                            <li className="group flex items-center gap-4 rounded-2xl px-3 py-3 transition hover:bg-slate-100/60 dark:hover:bg-slate-800/50">
                                <!-- Dynamic Inline Icon per Category -->
                                <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $tone }}">
                                    @switch($category)
                                    @case('Dining')
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 2v6a3 3 0 0 1-3 3 3 3 0 0 1-3-3V2"></path>
                                        <path d="M15 2v16"></path>
                                        <path d="M8 2v18"></path>
                                        <path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"></path>
                                    </svg>
                                    @break
                                    @case('Transport')
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"></path>
                                        <circle cx="7" cy="17" r="2"></circle>
                                        <path d="M9 17h6"></path>
                                        <circle cx="17" cy="17" r="2"></circle>
                                    </svg>
                                    @break
                                    @case('Shopping')
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    @break
                                    @case('Groceries')
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="8" cy="21" r="1"></circle>
                                        <circle cx="19" cy="21" r="1"></circle>
                                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                                    </svg>
                                    @break
                                    @case('Entertainment')
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="20" height="20" x="2" y="2" rx="2.18" ry="2.18"></rect>
                                        <line x1="7" y1="2" x2="7" y2="22"></line>
                                        <line x1="17" y1="2" x2="17" y2="22"></line>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <line x1="2" y1="7" x2="7" y2="7"></line>
                                        <line x1="2" y1="17" x2="7" y2="17"></line>
                                        <line x1="17" y1="17" x2="22" y2="17"></line>
                                        <line x1="17" y1="7" x2="22" y2="7"></line>
                                    </svg>
                                    @break
                                    @default
                                    <svg className="h-[18px] w-[18px] stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                    </svg>
                                    @endswitch
                                </div>

                                <!-- Transaction info -->
                                <div className="min-w-0 flex-1">
                                    <div className="flex items-center gap-2">
                                        <p className="truncate text-[15px] font-medium text-slate-900 dark:text-slate-100">{{ $t['vendor'] }}</p>
                                        @if(!empty($t['tags'][0]))
                                        <span className="hidden rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-medium text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 sm:inline">
                                            {{ $t['tags'][0] }}
                                        </span>
                                        @endif
                                    </div>
                                    <p className="mt-0.5 text-xs text-slate-500">
                                        {{ $category }} · {{ \Carbon\Carbon::parse($t['date'])->format('M j') }}
                                    </p>
                                </div>

                                <!-- Amount -->
                                <div className="text-right">
                                    <p className="text-[15px] font-semibold tabular-nums text-slate-900 dark:text-slate-100">
                                        −${{ number_format($t['amount'], 2) }}
                                    </p>
                                </div>

                                <!-- Options Menu Button -->
                                <button className="flex h-8 w-8 items-center justify-center rounded-full text-slate-400 opacity-0 transition hover:bg-slate-200/60 hover:text-slate-700 group-hover:opacity-100 dark:hover:bg-slate-800 dark:hover:text-slate-200">
                                    <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Spending Breakdown Donut & Budget Panel -->
                <div className="flex flex-col gap-6 lg:col-span-4">
                    <!-- Spending Summary Section -->
                    <div className="rounded-[28px] border border-slate-200/70 bg-white/70 p-7 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/70">
                        <div className="flex items-start justify-between">
                            <div>
                                <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Spending summary</p>
                                <h3 className="mt-1 text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100">September breakdown</h3>
                            </div>
                            <button className="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:text-slate-900 dark:border-slate-800 dark:hover:text-slate-100">
                                View report
                            </button>
                        </div>

                        <!-- Pure Conic-Gradient Donut Chart Component -->
                        @php
                        // Construct pure CSS conic-gradient string for donut chart visualization
                        $gradientParts = [];
                        $currentDegrees = 0;
                        foreach ($spentByCategory as $catName => $val) {
                        $pct = $totalSpent > 0 ? ($val / $totalSpent) : 0;
                        $degrees = $pct * 360;
                        $color = $categorySwatches[$catName] ?? '#94a3b8';
                        $nextDegrees = $currentDegrees + $degrees;
                        $gradientParts[] = "{$color} {$currentDegrees}deg {$nextDegrees}deg";
                        $currentDegrees = $nextDegrees;
                        }
                        $conicBg = !empty($gradientParts) ? 'conic-gradient(' . implode(', ', $gradientParts) . ')' : 'conic-gradient(#e2e8f0 0deg 360deg)';
                        @endphp

                        <div className="relative my-6 flex h-[220px] w-full items-center justify-center">
                            <!-- Donut Outer Ring -->
                            <div className="relative flex h-[190px] w-[190px] items-center justify-center rounded-full shadow-inner transition-transform duration-500 hover:scale-105"
                                style="background: {{ $conicBg }};">
                                <!-- Inner Cutout Hole -->
                                <div className="flex h-[135px] w-[135px] flex-col items-center justify-center rounded-full bg-white shadow-sm dark:bg-slate-900">
                                    <p className="text-[10px] font-medium uppercase tracking-[0.18em] text-slate-400">This month</p>
                                    <p className="mt-0.5 text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
                                        ${{ number_format($totalSpent, 0) }}
                                    </p>
                                    <p className="mt-0.5 text-[11px] text-slate-500">across {{ count($spentByCategory) }} categories</p>
                                </div>
                            </div>
                        </div>

                        <!-- Category List breakdown -->
                        <div className="space-y-3">
                            @foreach ($spentByCategory as $catName => $val)
                            @php
                            $pct = $totalSpent > 0 ? round(($val / $totalSpent) * 100) : 0;
                            $swatchColor = $categorySwatches[$catName] ?? '#94a3b8';
                            @endphp
                            <div className="flex items-center gap-3">
                                <span className="h-2.5 w-2.5 rounded-full" style="background-color: {{ $swatchColor }};"></span>
                                <span className="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $catName }}</span>
                                <span className="ml-auto text-sm text-slate-500">{{ $pct }}%</span>
                                <span className="w-16 text-right text-sm font-semibold tabular-nums text-slate-900 dark:text-slate-100">
                                    ${{ number_format($val, 0) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Budget Panel Component -->
                    <div className="rounded-[28px] border border-slate-200/70 bg-white/70 p-7 shadow-sm backdrop-blur-md dark:border-slate-800/70 dark:bg-slate-900/70">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-[11px] font-medium uppercase tracking-[0.18em] text-slate-500">Monthly budgets</p>
                                <h3 className="mt-1 text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-100">Limits & progress</h3>
                            </div>

                            <!-- Action Toggle Buttons -->
                            <template x-if="editingBudget">
                                <div className="flex items-center gap-1.5">
                                    <button
                                        @click="saveBudgets()"
                                        className="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white shadow-sm transition hover:opacity-90 dark:bg-slate-100 dark:text-slate-900">
                                        <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </button>
                                    <button
                                        @click="cancelBudgetEdit()"
                                        className="flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:text-slate-900 dark:border-slate-800 dark:hover:text-slate-100">
                                        <svg className="h-4 w-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <template x-if="!editingBudget">
                                <button
                                    @click="editingBudget = true"
                                    className="flex items-center gap-1.5 rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-500 transition hover:text-slate-900 dark:border-slate-800 dark:hover:text-slate-100">
                                    <svg className="h-3.5 w-3.5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                    Edit
                                </button>
                            </template>
                        </div>

                        <!-- Total Allocation Display -->
                        <div x-show="totalLimitValue > 0" className="mt-4 flex items-center justify-between rounded-2xl bg-slate-100/60 px-4 py-2.5 dark:bg-slate-800/50">
                            <span className="text-xs font-medium text-slate-500">Total allocated</span>
                            <span className="text-sm font-semibold tabular-nums text-slate-900 dark:text-slate-100">
                                ${{ number_format($totalSpent, 0) }} / $<span x-text="totalLimitValue.toLocaleString()">{{ number_format($totalLimit, 0) }}</span>
                            </span>
                        </div>

                        <!-- Category Budget Sliders / Inputs -->
                        <div className="mt-5 space-y-4">
                            @foreach ($categories as $cat)
                            @php
                            $swatchColor = $categorySwatches[$cat] ?? '#94a3b8';
                            @endphp
                            <div x-data="{
                                cat: '{{ $cat }}',
                                get used() { return this.spent[this.cat] || 0; },
                                get limit() { return Number(this.budgets[this.cat] || 0); },
                                get draft() { return this.draftBudgets[this.cat] ?? 0; },
                                get pct() { return this.limit > 0 ? Math.min((this.used / this.limit) * 100, 100) : 0; },
                                get remaining() { return Math.max(this.limit - this.used, 0); },
                                get isOver() { return this.used > this.limit && this.limit > 0; }
                            }">
                                <div className="flex items-center justify-between">
                                    <div className="flex items-center gap-2">
                                        <span className="h-2.5 w-2.5 rounded-full" style="background-color: {{ $swatchColor }};"></span>
                                        <span className="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $cat }}</span>
                                    </div>

                                    <!-- Edit View -->
                                    <template x-if="editingBudget">
                                        <div className="flex items-center gap-1 text-sm">
                                            <span className="text-slate-400">$</span>
                                            <input
                                                type="number"
                                                min="0"
                                                step="10"
                                                x-model.number="draftBudgets[cat]"
                                                className="w-20 rounded-lg border border-slate-200 bg-white px-2 py-1 text-right font-medium tabular-nums text-slate-900 focus:border-emerald-500/50 focus:outline-none dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100" />
                                        </div>
                                    </template>

                                    <!-- Normal View -->
                                    <template x-if="!editingBudget">
                                        <div>
                                            <template x-if="limit > 0">
                                                <span :class="isOver ? 'font-semibold text-rose-600 dark:text-rose-400' : 'text-slate-500'" className="text-sm tabular-nums">
                                                    <span x-text="isOver ? `+$${(used - limit).toLocaleString()} over` : `$${remaining.toLocaleString()} left`"></span>
                                                </span>
                                            </template>
                                            <template x-if="limit <= 0">
                                                <span className="text-xs text-slate-400">No limit</span>
                                            </template>
                                        </div>
                                    </template>
                                </div>

                                <!-- Progress Bar View -->
                                <template x-if="limit > 0 && !editingBudget">
                                    <div className="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                        <div
                                            className="h-full rounded-full transition-all duration-500"
                                            :class="pct >= 100 ? 'bg-rose-500' : pct >= 80 ? 'bg-amber-500' : 'bg-emerald-500'"
                                            :style="`width: ${pct}%`">
                                        </div>
                                    </div>
                                </template>

                                <template x-if="limit > 0 && !editingBudget">
                                    <p className="mt-1 text-xs text-slate-500">
                                        $<span x-text="used.toLocaleString()"></span> of $<span x-text="limit.toLocaleString()"></span> spent
                                    </p>
                                </template>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer className="mt-12 flex items-center justify-between text-xs text-slate-400">
                <p>BAS24 AI · Your private money companion</p>
                <p>All amounts in USD</p>
            </footer>
        </main>
    </div>
</x-guest-layout>