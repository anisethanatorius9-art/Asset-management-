<?php

namespace App\Http\Livewire\Assets;

use Livewire\Volt\Component;
use App\Livewire\Forms\AssetForm;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Location;
use App\Traits\TableExportable;
use Flux\Flux;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Computed;
use App\Traits\TableSortable;
use App\Traits\TableSearchable;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination, TableSortable, TableSearchable, TableExportable;
    use WithPagination, WithoutUrlPagination;

    public AssetForm $form;
    public $assetObj;
    public $categories;
    public $locations;

    public function mount()
    {
        $this->loadData();
    }

    public function export($type)
    {
        $query = $this->getQuery();
        $name = date('Y-m-d-His') . '-Groups files';
        return $this->exportFile($type, $query, self::ASSETVIEW, $name);
    }

    public function editAssetModel($id)
    {
        $this->assetObj = null;
        $this->assetObj = Asset::find($id);

        // Fill form with current asset data
        $this->form->fill($this->assetObj->toArray());

        Flux::modal('edit-asset')->show();
    }

    public function createAsset()
    {
        try {
            $this->form->validate();

            $asset = new Asset();
            $asset->fill($this->form->toArray());
            $asset->save();

            $this->form->reset();

            Flux::modal('add-asset')->close();

            Flux::toast(
                heading: 'Created.',
                text: 'Your asset has been created.',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Log::error('Asset creation failed: ' . $e->getMessage());

            Flux::toast(
                heading: 'Error.',
                text: 'Failed to create asset. Please try again.',
                variant: 'danger',
            );
        }
    }

    public function editAsset()
    {
        $this->form->validate();
        $asset = Asset::findOrFail($this->assetObj->id);

        $asset->fill($this->form->toArray());
        $asset->save();

        $this->form->reset();

        Flux::toast(
            heading: 'Edited.',
            text: 'The asset has been updated.',
            variant: 'success',
        );

        Flux::modal('edit-asset')->close();
    }

    protected function getQuery()
    {
        $query = Asset::query();
        $this->applyAssetSearch($query);
        return $query;
    }

    #[Computed]
    public function assets()
    {
        return $this->getQuery()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate($this->page_number_table);
    }

    protected function loadData()
    {
        $this->categories = Category::all();
        $this->locations = Location::all();
    }
}
