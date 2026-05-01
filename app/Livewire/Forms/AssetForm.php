<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AssetForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255|unique:assets,serial_number')]
    public $serial_number = '';

    #[Validate('nullable|string|max:255')]
    public $model = '';

    #[Validate('nullable|string|max:255')]
    public $manufacturer = '';

    #[Validate('nullable|date')]
    public $purchase_date = '';

    #[Validate('nullable|numeric|min:0')]
    public $purchase_price = '';

    #[Validate('required|string|max:50')]
    public $status = 'in_use';

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('required|exists:locations,id')]
    public $location_id = '';
}
// This code defines a Livewire form for managing asset data, including validation rules for each field.
// The form includes fields for asset name, serial number, model, manufacturer, purchase date,
// purchase price, status, category ID, and location ID. Each field has specific validation rules
// to ensure data integrity, such as required fields, string length limits, and unique constraints.
