<?php

namespace App\Http\Livewire\Management\Admin;

use Livewire\Component;
use App\Models\Management\Aduit;
use Illuminate\Support\Facades\DB;

class AnomalychartComponent extends Component
{
    public function render()
    {
        $data['anomaly_counts'] = Aduit::where('status','!=','Canceled')->select(DB::raw('count(id) as audit_count'), 'anomaly')->groupBy('anomaly')->get();
        return view('livewire.management.admin.anomalychart-component', $data);
    }
}
