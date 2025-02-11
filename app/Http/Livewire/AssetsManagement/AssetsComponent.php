<?php

namespace App\Http\Livewire\AssetsManagement;

use Livewire\Component;

class AssetsComponent extends Component
{
    public function render()
    {
        return view('livewire.assets-management.assets-component')->layout('layouts.assets');
    }
}
