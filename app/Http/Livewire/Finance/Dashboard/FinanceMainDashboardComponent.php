<?php

namespace App\Http\Livewire\Finance\Dashboard;

use Livewire\Component;

class FinanceMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.finance.dashboard.finance-main-dashboard-component')->layout('layouts.finance');
    }
}
