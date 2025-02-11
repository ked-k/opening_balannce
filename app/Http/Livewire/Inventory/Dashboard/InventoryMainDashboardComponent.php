<?php

namespace App\Http\Livewire\Inventory\Dashboard;

use Livewire\Component;

class InventoryMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.inventory.dashboard.inventory-main-dashboard-component')->layout('layouts.inventory');
    }
}
