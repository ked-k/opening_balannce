<?php

namespace App\Http\Livewire\Management\Admin;

use Livewire\Component;
use App\Models\Management\Aduit;
use Illuminate\Support\Facades\DB;

class StatuschartComponent extends Component
{
    public function render()
    {
        $data['anomaly_status'] = Aduit::where('status','!=','Canceled')->select(DB::raw('count(id) as audit_count'), 'status')->groupBy('status')->get();
        return view('livewire.management.admin.statuschart-component',$data);
    }
}
