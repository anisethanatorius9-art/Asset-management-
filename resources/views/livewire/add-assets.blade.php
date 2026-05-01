<div>
    <flux:modal.trigger name="edit-profile">
    <flux:button>Add assets</flux:button>
</flux:modal.trigger>

<flux:modal name="edit-profile" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Update profile</flux:heading>
            <flux:text class="mt-2">Make changes to your personal details.</flux:text>
        </div>

        <flux:input label="Assets" placeholder="Add assets" />

        <flux:input label="Serial no" type="string" />

        <flux:input label="CategoryID" type="foreignId" />

        <flux:input label="Model" type="string" />

        <flux:input label="Purchase date" type="date" />

        <flux:input label="Purchase-cost" type="decimal" />

        <flux:input label="Department ID" type="foreignId" />

        <flux:input label="Location ID" type="foreignId" />

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Save changes</flux:button>
        </div>
    </div>
</flux:modal>
</div>
