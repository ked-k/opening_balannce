<?php

namespace App\Http\Livewire\Management;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Management\Zone;
use App\Models\Management\Aduit;
use App\Models\Management\Feeder;
use Illuminate\Support\Facades\DB;
use App\Models\Management\District;
use App\View\Components\AppLayout;

class AdminDashboard extends Component
{
    public $zone_id,$from_date,$to_date;
    public function render()
    {
        $data['audit_counts'] = Aduit::where('status','!=','Pending')->get();
        $data['users']=User::count();

        $data['feeders']=Feeder::count();
        $data['districts']=District::count();
        $data['zones']=Zone::count();

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    

        
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('livewire.management.admin-dashboard', $data)->layout('layouts.app');
    }
}
