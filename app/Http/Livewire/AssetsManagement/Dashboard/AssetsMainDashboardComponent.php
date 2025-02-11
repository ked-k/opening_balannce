<?php

namespace App\Http\Livewire\AssetsManagement\Dashboard;

use Livewire\Component;

class AssetsMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.assets-management.dashboard.assets-main-dashboard-component')->layout('layouts.assets');
    }
}
