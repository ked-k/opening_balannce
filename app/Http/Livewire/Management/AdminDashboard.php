<?php

namespace App\Http\Livewire\Management;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $zone_id, $from_date, $to_date;
    public function render()
    {
        $data['audit_counts'] = User::get();
        $data['users'] = User::count();

        $data['feeders'] = User::count();
        $data['districts'] = User::count();
        $data['zones'] = User::count();

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('livewire.management.admin-dashboard', $data);
    }
}
