<?php

namespace App\Http\Livewire\Documents\Dashboard;

use Livewire\Component;

class DocumentsMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.documents.dashboard.documents-main-dashboard-component')->layout('layouts.documents');
    }
}
