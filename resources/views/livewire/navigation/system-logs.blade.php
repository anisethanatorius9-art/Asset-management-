<?php

use Livewire\Volt\Component;
use App\Models\SystemLog;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use App\Traits\TableSortable;
use Illuminate\Database\Eloquent\Builder;

new class extends Component {
    use WithPagination, WithoutUrlPagination, TableSortable;

    public string $search_table = '';
    public int $page_number_table = 10;

    protected function applySearch(Builder $query): Builder
    {
        if (! $this->search_table) {
            return $query;
        }

        return $query->where(function ($q) {
            $q->orWhere('user', 'like', '%' . $this->search_table . '%')
                ->orWhere('action', 'like', '%' . $this->search_table . '%')
                ->orWhere('description', 'like', '%' . $this->search_table . '%');
        });
    }

    #[Computed]
    public function logs()
    {
        return SystemLog::query()
            ->tap(fn ($query) => $this->applySearch($query))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->page_number_table);
    }
}; ?>

<div>
    <div class="p-4 w-full">
        <flux:heading>System Logs</flux:heading>
        <flux:text class="mt-2">View application activity and audit events.</flux:text>

        <div class="mt-6">
            <x-tables.searchable />

            <flux:table :paginate="$this->logs">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                        wire:click="sort('created_at')">Date</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'user'" :direction="$sortDirection"
                        wire:click="sort('user')">User</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                    <flux:table.column>Description</flux:table.column>
                    <flux:table.column align="end">Time</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @forelse ($this->logs as $log)
                        <flux:table.row :key="$log->id">
                            <flux:table.cell class="whitespace-nowrap">{{ $log->created_at?->format('Y-m-d') }}</flux:table.cell>
                            <flux:table.cell class="whitespace-nowrap">{{ $log->user }}</flux:table.cell>
                            <flux:table.cell>{{ $log->action }}</flux:table.cell>
                            <flux:table.cell class="whitespace-normal">{{ $log->description }}</flux:table.cell>
                            <flux:table.cell class="whitespace-nowrap" align="end">{{ $log->created_at?->format('H:i:s') }}</flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5">No system logs found.</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
</div>
