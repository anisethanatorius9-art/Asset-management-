<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;

class CategorieForm extends Form
{
    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('nullable|string|max:100|unique:categories,code')]
    public $code;

    #[Validate('nullable|string')]
    public $description;

    #[Validate('boolean')]
    public $is_active = true;
}
