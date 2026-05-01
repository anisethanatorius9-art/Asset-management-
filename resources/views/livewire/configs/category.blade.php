<?php

use Livewire\Volt\Component;
use App\Livewire\Forms\CategorieForm;
use App\Models\Category;
use App\Traits\TableExportable;
use Flux\Flux;
use \Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use \Livewire\Attributes\Computed;
use App\Traits\TableSortable;
use App\Traits\TableSearchable;
use Illuminate\Support\Facades\Log;

new class extends Component {
    use WithPagination, TableSortable, TableSearchable, TableExportable;
    use WithPagination, WithoutUrlPagination;

    public CategorieForm $form;
    public $categorieObj;

    public function mount() {}

     public function export($type)
    {
        $query = $this->getQuery();
        $name = date('Y-m-d-His') . '-Groups files';
        return $this->exportFile($type, $query, self::CATEGORYVIEW, $name);
    }

    public function editCategoryModel($id)
    {
        $this->categorieObj = null;
        $this->categorieObj = Category::find($id);

        $this->form->name = $this->categorieObj->name;
        $this->form->code = $this->categorieObj->code;
        $this->form->description = $this->categorieObj->description;
        $this->form->is_active = $this->categorieObj->is_active;

        Flux::modal('edit-category')->show();
    }


    public function createCategorie()
    {
        try {
            $this->form->validate();

            $categorie = new Category();
            $categorie->name = $this->form->name;
            $categorie->code = $this->form->code;
            $categorie->description = $this->form->description;
            $categorie->is_active = $this->form->is_active;
            $categorie->save();

            $this->form->reset();
            Flux::modal('add-categorie')->close();

            Flux::toast(
                heading: 'Created.',
                text: 'Your category has been created.',
                variant: 'success',
            );
        } catch (\Throwable $e) {
            Log::error('Categorie creation failed: ' . $e->getMessage());

            Flux::toast(
                heading: 'Error.',
                text: 'Failed to create category. Please try again.',
                variant: 'danger',
            );
        }
    }

    public function editCategory()
    {
        $this->form->validate();
        $categorie = Category::findOrFail($this->categorieObj->id);

        // Example update, you can later replace this with a modal or inline input
        $categorie->name = $this->form->name;
        $categorie->code = $this->form->code;
        $categorie->description = $this->form->description;
        $categorie->is_active = $this->form->is_active;
        $categorie->save();

        $this->form->reset();

        Flux::toast(
            heading: 'Edited.',
            text: 'The' . $this->form->name . 'The category has been updated.',
            variant: 'success',
        );
        //close edit modal
        Flux::modal('edit-category')->close();
    }

    protected function getQuery()
    {
        $query = Category::query();
        $this->applyCategorieSearch($query);
        return $query;
    }

    #[Computed]
    public function categories()
    {
        return $this->getQuery()
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate($this->page_number_table);
    }
};
?>

<div>
    <flux:heading size="xl" level="1">{{ __('Categories') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Your categories') }}</flux:subheading>



    <flux:modal.trigger name="add-category">
        <div class="flex justify-end">
            <flux:button class="mt-4" icon="plus">New Category</flux:button>
        </div>
    </flux:modal.trigger>
    <flux:separator class="my-4" />


    <x-tables.searchable />
    <flux:table :paginate="$this->categories">
        <flux:table.columns>
            <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">NAME</flux:table.column>
            <flux:table.column>CODE</flux:table.column>
            <flux:table.column>DESCRIPTION</flux:table.column>
            <flux:table.column>STATUS</flux:table.column>
            <flux:table.column align="end">ACTION</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->categories as $category)
            <flux:table.row>
                <flux:table.cell class="whitespace-normal">{{$category->name}}</flux:table.cell>
                <flux:table.cell>{{$category->code}}</flux:table.cell>
                <flux:table.cell>{{$category->description}}</flux:table.cell>
                <flux:table.cell>
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                </flux:table.cell>

                <flux:table.cell align="end">
                    <!-- Edit button -->
                    <flux:button size="sm" variant="ghost" wire:click="editCategoryModel({{ $category->id }})"
                        icon="pencil-square">

                        Edit
                    </flux:button>

                    <!-- Delete button -->

                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <!-- Create modal -->
    <flux:modal name="add-category" class="md:w-full">
        <div class="space-y-6">
            <form wire:submit="createCategorie" class="space-y-6">
                <div>
                    <flux:heading size="lg">Create Category</flux:heading>
                    <flux:text class="mt-2">Provide correct information about the category.</flux:text>
                </div>

                <flux:input label="Name" wire:model="form.name" placeholder="Category name" />
                <flux:input label="Code" wire:model="form.code" placeholder="Category code" />
                <flux:textarea label="Description" wire:model="form.description" placeholder="Description" />
                <flux:switch label="Active" wire:model="form.is_active" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit modal -->
    <flux:modal name="edit-category" class="md:w-full">
        <div class="space-y-6">
            <form wire:submit="editCategory" class="space-y-6">

                @if($categorieObj)
                <div>
                    <flux:heading size="lg">Edit Category: {{ $categorieObj->name }}</flux:heading>
                    <flux:text class="mt-2">Provide Correct information about this category.</flux:text>
                </div>

                <flux:input label="Name" wire:model="form.name" placeholder="Category name" />
                <flux:input label="Code" wire:model="form.code" placeholder="Category code" />
                <flux:textarea label="Description" wire:model="form.description" placeholder="Description" />
                <flux:switch label="Active" wire:model="form.is_active" />

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>

                @endif
            </form>
        </div>
    </flux:modal>

</div>
