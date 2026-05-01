<?php

namespace App\Livewire;

use Livewire\Component;

class CatalogSelector extends Component
{
    public function render()
    {
        return view('livewire.catalog-selector')->layout('layouts.livewire');
    }
}
