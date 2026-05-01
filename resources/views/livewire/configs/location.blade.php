<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\LocationForm;
use App\Models\Location;
use Flux\Flux;
use \Livewire\WithPagination;
use \Livewire\WithoutUrlPagination;
use \Livewire\Attributes\Computed;
use App\Traits\TableSortable;
use App\Traits\TableSearchable;
use App\Traits\TableExportable;
use App\Helpers\Helper;
use App\Exports\LocationsExport;

new class extends Component {

    use WithPagination, TableSortable, TableSearchable, TableExportable, WithoutUrlPagination;
    public LocationForm $form;
    public $locationOb;

    public function mount()
    {
        // $this->locations = Location::all();
    }

    public function export($type)
    {
        $query = $this->getQuery();
        $name = date('Y-m-d-His') . '-Groups files';
        return $this->exportFile($type, $query, self::GROUPVIEW, $name);
    }


    public function editLocationModel($id)
    {
        $this->locationOb = null;
        $this->locationOb = Location::findOrFail($id);
        $this->form->name = $this->locationOb->name;

        Flux::modal('edit-location')->show();
    }

    public function createLocation()
    {
        $this->form->validate();

        $location = Location::where('name', $this->form->name)->first();
        if ($location) {
            Helper::errorToast("Location with name {$this->form->name} already exists.");
            return;
        }

        try {
            $location = new Location();
            $location->name = $this->form->name;

            DB::transaction(function () use ($location) {
                $location->save();

                activity('location creation')
                    ->causedBy(auth()->user())
                    ->performedOn($location)
                    ->event('CREATED')
                    ->withProperties(['location_id' => $location->id])
                    ->log('Created location: ' . $location->name);

                Helper::successToast("{$location->name} has been created.");
            });

            $this->form->reset();

        } catch (\Exception $e) {
            Log::error('Failed to create location: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            activity('location creation')
                ->causedBy(auth()->user())
                ->event('FAILED')
                ->log("Failed to create location with name:  {$this->form->name} and trace : {$e->getTraceAsString()}");

            Helper::errorToast('Failed to create location. Please try again later.');
        }
    }


    public function editLocation()
    {
        $this->form->validate();
        $location = Location::findOrFail($this->location->id);

        // Example update, you can later replace this with a modal or inline input
        $location->name = $this->form->name;
        $location->save();

        Flux::toast(
            heading: 'Edited.',
            text: 'The ' . $this->form->name . ' location has been updated.',
            variant: 'success',
        );

        Flux::modal('edit-location')->close();
    }

    protected function getQuery()
    {
        $query = Location::query();
        $this->applyLocationSearch($query);
        return $query;
    }

    #[Computed]
    public function locations()
    {
        return $this->getQuery()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate($this->page_number_table);
    }

}; ?>

<div>
    <div class="p-4 w-full">
        <flux:heading>Location</flux:heading>
        <flux:text class="mt-2">Manage institution Location</flux:text>
        <div class="mb-4 flex items-center justify-end">

            <flux:modal.trigger name="add-location">
                <flux:button variant="primary" icon="plus" wire:click="createLocation" wire:navigate>
                    Add Location
                </flux:button>
            </flux:modal.trigger>

        </div>
        <flux:separator class="my-3" />

        <div class="mt-6">
            <x-tables.searchable excel/>
            <flux:table :paginate="$this->locations">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection"
                        wire:click="sort('name')">Location</flux:table.column>

                    <flux:table.column align="end">Action</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->locations as $location)
                        <flux:table.row :key="$location->id">

                            <flux:table.cell class="whitespace-nowrap">{{ $location->name }}</flux:table.cell>

                            <flux:table.cell align="end">

                                <flux:button size="sm" variant="ghost" wire:click="editLocationModel({{ $location->id }})"
                                    icon="pencil-square"> Edit
                                </flux:button>

                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
    </div>


    <flux:modal name="add-location" class="md:w-full">
        <div class="space-y-6">

            <form wire:submit="createLocation" class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Office Location</flux:heading>
                    <flux:text class="mt-2">Provide Correct information about your office.</flux:text>
                </div>

                <flux:input label="Location" wire:model="form.name" placeholder="Location name" autofocus />


                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <flux:modal name="edit-location" class="md:w-full">
        <div class="space-y-6">

            <form wire:submit="editLocation" class="space-y-6">

                @if($locationOb)
                    <div>
                        <flux:heading size="lg">Edit Office Location: {{ $locationOb->name }}</flux:heading>
                        <flux:text class="mt-2">Provide Correct information about your office.</flux:text>
                    </div>

                    <flux:input label="Location" wire:model="form.name" placeholder="Location name" />

                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" variant="primary">Save</flux:button>
                    </div>

                @endif
            </form>
        </div>
    </flux:modal>

</div>
