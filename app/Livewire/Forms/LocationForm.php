<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class LocationForm extends Form
{
    #[Validate('required|min:3|max:255|unique:locations,name')]
    public $name = '';

}
