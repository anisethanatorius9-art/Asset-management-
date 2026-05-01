<?php

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

new class extends Component {
    use WithPagination, TableSortable, TableSearchable,TableExportable;
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
};
?>

<div>
    <flux:heading size="xl" level="1">{{ __('Assets') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Your assets') }}</flux:subheading>

    <flux:modal.trigger name="add-asset">
        <div class="flex justify-end">
            <flux:button class="mt-4" icon="plus">New Asset</flux:button>
        </div>
    </flux:modal.trigger>
    <flux:separator class="my-4" />

    <x-tables.searchable />
    <flux:table :paginate="$this->assets">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">Name</flux:table.column>
            <flux:table.column>Serial</flux:table.column>
            <flux:table.column>Model</flux:table.column>
            <flux:table.column>Manufacturer</flux:table.column>
            <flux:table.column>Purchase date</flux:table.column>
            <flux:table.column>Purchase price</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Category</flux:table.column>
            <flux:table.column>Location</flux:table.column>
            <flux:table.column align="end">ACTION</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->assets as $asset)
            <flux:table.row>
                <flux:table.cell>{{$asset->name}}</flux:table.cell>
                <flux:table.cell>{{$asset->serial_number}}</flux:table.cell>
                <flux:table.cell>{{$asset->model}}</flux:table.cell>
                <flux:table.cell>{{$asset->manufacturer}}</flux:table.cell>
                <flux:table.cell>{{$asset->purchase_date}}</flux:table.cell>
                <flux:table.cell>{{ $asset->purchase_price}}</flux:table.cell>
                <flux:table.cell>{{$asset->status}}</flux:table.cell>
                <flux:table.cell>{{$asset->category?->name}}</flux:table.cell>
                <flux:table.cell>{{$asset->location?->name}}</flux:table.cell>

                <flux:table.cell align="end">
                    <flux:button size="sm" variant="ghost" wire:click="editAssetModel({{ $asset->id }})"
                        icon="pencil-square">
                        Edit
                    </flux:button>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <!-- Create Modal -->
    <flux:modal name="add-asset" class="md:w-full">
        <form wire:submit="createAsset" class="space-y-6">
            <flux:heading size="lg">Create Asset</flux:heading>

            <flux:input label="Name" wire:model="form.name" placeholder="Asset name" />
            <flux:input label="Serial Number" wire:model="form.serial_number" placeholder="Unique serial" />
            <flux:input label="Model" wire:model="form.model" placeholder="Model" />
            <flux:input label="Manufacturer" wire:model="form.manufacturer" placeholder="Manufacturer" />
            <flux:input type="date" label="Purchase Date" wire:model="form.purchase_date" />
            <flux:input type="number" step="0.01" label="Purchase Price" wire:model="form.purchase_price" />
            <flux:input label="Status" wire:model="form.status" placeholder="e.g. in_use" />

            <flux:select label="Category" wire:model="form.category_id">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </flux:select>

            <flux:select label="Location" wire:model="form.location_id">
                <option value="">-- Select Location --</option>
                @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Modal -->
    <flux:modal name="edit-asset" class="md:w-full">
        <form wire:submit="editAsset" class="space-y-6">
            @if($assetObj)
            <flux:heading size="lg">Edit Asset: {{ $assetObj->name }}</flux:heading>

            <flux:input label="Name" wire:model="form.name" />
            <flux:input label="Serial Number" wire:model="form.serial_number" />
            <flux:input label="Model" wire:model="form.model" />
            <flux:input label="Manufacturer" wire:model="form.manufacturer" />
            <flux:input type="date" label="Purchase Date" wire:model="form.purchase_date" />
            <flux:input type="number" step="0.01" label="Purchase Price" wire:model="form.purchase_price" />
            <flux:input label="Status" wire:model="form.status" />

            <flux:select label="Category" wire:model="form.category_id">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </flux:select>

            <flux:select label="Location" wire:model="form.location_id">
                <option value="">-- Select Location --</option>
                @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </flux:select>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
            @endif
        </form>
    </flux:modal>
</div>
