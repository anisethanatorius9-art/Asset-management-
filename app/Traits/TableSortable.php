<?php

namespace App\Traits;

use Livewire\Attributes\Session;

trait TableSortable
{

    #[Session]
    public $sortBy = 'created_at'; //

    #[Session]
    public $sortDirection = 'desc'; //

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }
}
