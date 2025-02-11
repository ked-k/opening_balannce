<?php

namespace App\Http\Livewire\Management\Admin;

use Livewire\Component;
use App\Models\Management\Aduit;
use Illuminate\Support\Facades\DB;

class MainbarComponent extends Component
{
    public function render()
    {           DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data['main_chart'] = Aduit::where('status','!=','Canceled')
        ->selectRaw('COUNT(*) AS total_audits')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Meter Bypass" THEN 1 END) AS meter_bypass')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Faulty Meter" THEN 1 END) AS faulty')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Meter Ok" THEN 1 END) AS meter_ok')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Stolen Meter" THEN 1 END) AS stolen')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Abandoned Meter" THEN 1 END) AS abandoned')
                                  ->selectRaw('COUNT(CASE WHEN anomaly = "Tampered Meter" THEN 1 END) AS tampered')
                                  ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                                  ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                                  ->groupBy('new_date')->orderBy('new_date', 'ASC')
        ->get();

        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('livewire.management.admin.mainbar-component',$data)->layout('layouts.chart');
    }
}
