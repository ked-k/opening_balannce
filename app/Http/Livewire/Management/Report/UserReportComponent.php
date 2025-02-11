<?php

namespace App\Http\Livewire\Management\Report;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Management\Zone;
use App\Models\Management\Aduit;
use App\Models\Management\Feeder;
use App\Models\Management\District;
use App\Models\Management\MeterType;
use App\Models\User;

class UserReportComponent extends Component
{
    
    public $purpose;
    public $district_id;
    public $zone_id;
    public $feeder_id;
    public $meter_type_id;
    public $anomaly;
    public $supply_type;
    public $created_by;   
    public $return_type ='list';   
    public $group_by;   
    public $audits;
    public $to_date, $from_date;
    public function mount()
    {
        $this->to_date = date('Y-m-d');
        $this->audits = collect([]);
    }
    public function updatedReturnType()
    {
        $this->audits = collect([]);
    }

    public function updatedCreatedBy()
    {
        $this->audits = collect([]);
    }

    public function updatedGroupBy()
    {
        $this->audits = collect([]);
    }
    public function filterAudits()
    {
        $audits= Aduit::with(['zone'])  
      
        ->when($this->district_id, function ($query) {
            $query->where('district_id', $this->district_id);
        })
        ->when($this->zone_id, function ($query) {$query->where('zone_id', $this->zone_id); })
        ->when($this->feeder_id, function ($query) {$query->where('feeder_id', $this->feeder_id); })
        ->when($this->meter_type_id, function ($query) {$query->where('meter_type_id', $this->meter_type_id); })
        ->when($this->anomaly, function ($query) {$query->where('anomaly', $this->anomaly); })
        ->when($this->created_by, function ($query) {$query->where('created_by', $this->created_by); })
        ->when($this->from_date, function ($query) {
            $from = Carbon::parse($this->from_date)->toDateTimeString();
            $to = Carbon::parse($this->to_date)->addHour(23)->addMinutes(59)->toDateTimeString();
            $query->whereBetween('created_at', [$from, $to]);
        });
        // ->when($this->return_type =='count', function ($query) {$query->groupBy('group_by'); });
        // ->get();
        if($this->return_type =='list'){
            $this->audits = $audits->get();
        }
        elseif($this->return_type =='count'){
            if($this->group_by =='User'){
                $this->audits = $audits->with('user')->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("created_by")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['created_by','new_date'])->orderBy('new_date', 'ASC')->get();
            }
            if($this->group_by =='District'){
                $this->audits = $audits->with('district')->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("district_id")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['district_id','new_date'])->orderBy('new_date', 'ASC')->get();
            }
            if($this->group_by =='Zone'){
                $this->audits = $audits->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("zone_id")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['zone_id','new_date'])->orderBy('new_date', 'ASC')->get();
            }
            if($this->group_by =='Anormaly'){
                $this->audits = $audits->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("anomaly")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['anomaly','new_date'])->orderBy('new_date', 'ASC')->get();
            }
            if($this->group_by =='Meter'){
                $this->audits = $audits->with('meterType')->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("meter_type_id")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['meter_type_id','new_date'])->orderBy('new_date', 'ASC')->get();
            }
            if($this->group_by =='Feeder'){
                $this->audits = $audits->with('feeder')->selectRaw('COUNT(*) AS number_count')
                ->selectRaw("feeder_id")
                ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') display_date")
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') new_date")
                ->groupBy(['feeder_id','new_date'])->orderBy('new_date', 'ASC')->get();
            }
        }else{
            $this->audits = collect([]);
        }
    }
    public function render()
    {
        $data['districts'] = District::where('is_active',1)->get();
        $data['meter_types'] = MeterType::where('is_active',1)->get();
        $data['zones'] = Zone::where('is_active',1)  ->when($this->district_id, function ($query) {
            $query->where('district_id', $this->district_id);
        })->get();
        $data['feeders'] = Feeder::where('is_active',1)->get();
        $data['users'] =User::all();
        return view('livewire.management.report.user-report-component',$data);
    }
}
