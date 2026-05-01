@php
use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;

$totalAssets = Asset::count();
$totalAmount = Asset::sum('purchase_price');
$totalCategories = Category::count();
$totalLocations = Location::count();
$latestAssets = Asset::latest()->limit(5)->get();
$lastUpdated = Asset::latest()->first()?->created_at;
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6 bg-gray-50 dark:bg-neutral-950">

        <div class="grid gap-6 lg:grid-cols-[1.8fr_1fr]">
            <div class="rounded-3xl bg-gradient-to-r from-sky-600 via-indigo-600 to-purple-600 p-8 text-white shadow-xl shadow-sky-500/20">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="rounded-3xl bg-white/15 p-4 shadow-inner shadow-white/10">
                            <x-app-logo-icon class="size-7 text-white" />
                        </div>
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-sky-100">Asset Management</p>
                            <h1 class="mt-2 text-3xl font-semibold tracking-tight">Dashboard</h1>
                            <p class="mt-3 max-w-xl text-sm text-sky-100/90">
                                Welcome back! Here is your asset overview, quick actions, and the latest inventory updates.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-sky-100/80">Total value</p>
                            <p class="mt-2 text-2xl font-semibold">Tsh {{ Helper::formatNumber($totalAmount) }}</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-sky-100/80">Updated</p>
                            <p class="mt-2 text-2xl font-semibold">{{ $lastUpdated?->format('M d, Y') ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4">
                <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-neutral-900 dark:border dark:border-neutral-800">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Assets</p>
                    <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ Helper::formatNumber($totalAssets, 0) }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-neutral-900 dark:border dark:border-neutral-800">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Categories</p>
                    <p class="mt-2 text-3xl font-bold text-indigo-600">{{ Helper::formatNumber($totalCategories, 0) }}</p>
                </div>
                <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-neutral-900 dark:border dark:border-neutral-800">
                    <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Locations</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">{{ Helper::formatNumber($totalLocations, 0) }}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-neutral-900 dark:border dark:border-neutral-800">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Latest Assets</h2>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            Most recently added assets in your inventory.
                        </p>
                    </div>
                    <a href="{{ route('assets') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300">
                        View all assets
                    </a>
                </div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-neutral-200 dark:border-neutral-800">
                    <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-800">
                        <thead class="bg-neutral-50 dark:bg-neutral-950">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-neutral-500">Name</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-neutral-500">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-[0.2em] text-neutral-500">Location</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-[0.2em] text-neutral-500">Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200 bg-white dark:divide-neutral-800 dark:bg-neutral-950">
                            @forelse ($latestAssets as $asset)
                            <tr class="hover:bg-slate-50 dark:hover:bg-neutral-900">
                                <td class="px-4 py-4 text-sm text-neutral-900 dark:text-neutral-100">{{ $asset->name }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-400">{{ $asset->category?->name ?? '—' }}</td>
                                <td class="px-4 py-4 text-sm text-neutral-500 dark:text-neutral-400">{{ $asset->location?->name ?? '—' }}</td>
                                <td class="px-4 py-4 text-right text-sm font-semibold text-neutral-900 dark:text-neutral-100">Tsh {{ Helper::formatNumber($asset->purchase_price) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-neutral-500 dark:text-neutral-400">No recent assets found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm dark:bg-neutral-900 dark:border dark:border-neutral-800">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Quick Actions</h2>
                    <div class="mt-5 grid gap-3">
                        <a href="{{ route('assets') }}" class="block rounded-2xl border border-neutral-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-neutral-900 transition hover:border-sky-300 hover:bg-sky-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:hover:border-sky-500 dark:hover:bg-slate-900">
                            Browse all assets
                        </a>
                        <a href="{{ route('config.locations') }}" class="block rounded-2xl border border-neutral-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-neutral-900 transition hover:border-emerald-300 hover:bg-emerald-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:hover:border-emerald-500 dark:hover:bg-slate-900">
                            Manage locations
                        </a>
                        <a href="{{ route('config.categories') }}" class="block rounded-2xl border border-neutral-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-neutral-900 transition hover:border-violet-300 hover:bg-violet-50 dark:border-neutral-800 dark:bg-neutral-950 dark:text-neutral-100 dark:hover:border-violet-500 dark:hover:bg-slate-900">
                            Manage categories
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl bg-gradient-to-br from-sky-600 to-indigo-600 p-6 text-white shadow-xl shadow-sky-500/20">
                    <h2 class="text-lg font-semibold">System at a glance</h2>
                    <p class="mt-3 text-sm text-sky-100/90">Your asset platform is running smoothly. Use the links below to move quickly between modules.</p>
                    <div class="mt-6 grid gap-3">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-white/20">
                            <span>Dashboard overview</span>
                            <span class="text-sky-100/90">→</span>
                        </a>
                        <a href="{{ route('system-logs') }}" class="inline-flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-white/20">
                            <span>View system logs</span>
                            <span class="text-sky-100/90">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
