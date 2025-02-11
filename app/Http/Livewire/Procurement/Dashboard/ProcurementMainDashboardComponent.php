<?php

namespace App\Http\Livewire\Procurement\Dashboard;

use Livewire\Component;

class ProcurementMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.procurement.dashboard.procurement-main-dashboard-component')->layout('layouts.procurement');
    }
}
