@props([
    'page_numbers' => [5, 10, 25, 50, 100],
    'pdf' => true,
    'excel' => false
])

<div class="w-full mb-3">
    <div class="flex flex-col gap-2 md:flex-row md:items-center">
        <!-- Search field: mobile-first full width, grows on desktop -->
        <div class="w-full md:flex-1">
            <flux:input wire:model.live.debounce.300ms="search_table" placeholder="Search..." icon="magnifying-glass" />
        </div>

        <div class="w-full md:w-auto">
            <flux:select wire:model.live="page_number_table">
                @foreach ($page_numbers as $number)
                    <flux:select.option>{{ $number }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="w-full md:w-auto">
            <flux:dropdown align="end">

                <flux:button icon:trailing="arrow-down-tray">Export</flux:button>

                <flux:navmenu>
                    @if ($pdf)
                        <flux:navmenu.item wire:click="export('pdf')">Export as PDF</flux:navmenu.item>
                    @endif

                    @if ($excel)
                        <flux:navmenu.item wire:click="export('csv')">Export as CSV</flux:navmenu.item>
                    @endif

                </flux:navmenu>
            </flux:dropdown>
        </div>
    </div>
