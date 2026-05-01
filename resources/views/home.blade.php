{{-- resources/views/dashboard.blade.php --}}
<x-layouts.app :title="__('home')">
    <a href="{{ route('home') }}" class="text-blue-600 underline mb-4 inline-block">Go to Home</a>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Home</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded shadow">Widget 1</div>
            <div class="bg-white p-6 rounded shadow">Widget 2</div>
            <div class="bg-white p-6 rounded shadow">Widget 3</div>
        </div>
    </div>
</x-layouts.app>
public function createCategorie()
    {
        $this->form->validate();

         $categorie = new Category();
            $categorie->name = $this->form->name;
            $categorie->code = $this->form->code;
            $categorie->description = $this->form->description;
            $categorie->is_active = $this->form->is_active;
            $categorie->save();
        if ($Category) {
            Helper::errorToast("Category with name {$this->form->name} already exists.");
            return;
        }

        try {
        $this->form->validate();
        $categorie = new Category();
        $categorie->name = $this->form->name;
        $categorie->code = $this->form->code;
        $categorie->description = $this->form->description;
        $categorie->is_active = $this->form->is_active;
        $categorie->save();



            DB::transaction(function () use ($category) {
                $category->save();

                activity('category creation')
                    ->causedBy(auth()->user())
                    ->performedOn($category)
                    ->event('CREATED')
                    ->withProperties(['category_id' => $category->id])
                    ->log('Created category: ' . $category->name);

                Helper::successToast("{$category->name} has been created.");
            });

            $this->form->reset();

        } catch (\Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            activity('category creation')
                    ->causedBy(auth()->user())
                    ->event('FAILED')
                    ->log("Failed to create category with name:  {$this->form->name} and trace : {$e->getTraceAsString()}");

            Helper::errorToast('Failed to create category. Please try again later.');
        }
    }
