<?php

namespace App\Traits;

use Livewire\Attributes\Session;

trait TableSearchable
{
    #[Session]
    public $search_table = '';

    #[Session]
    public $page_number_table = 5;

    protected function applyLocationSearch($query)
    {
        if ($this->search_table) {
            $query->where(function ($q) {
                foreach ($this->searchableLocationFields() as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search_table . '%');
                }
            });
        }
        return $query;
    }

    protected function searchableLocationFields()
    {
        return ['name'];
    }

    protected function applyCategorieSearch($query)
    {
        if ($this->search_table) {
            $query->where(function ($q) {
                foreach ($this->searchableCategoryFields() as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search_table . '%');
                }
            });
        }
        return $query;
    }
    protected function searchableCategoryFields()
    {
        return ['name', 'code', 'description'];
    }
    protected function applyAssetSearch($query)
    {
        if ($this->search_table) {
            $query->where(function ($q) {
                foreach ($this->searchableAssetFields() as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search_table . '%');
                }
            });
        }
        return $query;
    }
    protected function searchableAssetFields()
    {
        return [
            'name',
            'serial_number',
            'model',
            'manufacturer',
            'purchase_date',
            'purchase_price',
            'status',
            'category_id',
            'location_id',
        ];
    }
}
