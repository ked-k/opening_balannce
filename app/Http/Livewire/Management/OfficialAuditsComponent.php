<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\Zone;
use App\Models\Management\Aduit;
use App\Models\Management\Feeder;
use App\Models\Management\District;
use App\Models\Management\MeterType;

class OfficialAuditsComponent extends Component
{
    use WithPagination;
    
    public $perPage = 15;

    public $search = '';

    public $orderBy = 'anomaly';

    public $orderAsc = true;
    public $createNew = false;

    public $mode = 'add';

    public $delete_id;

    public $edit_id;

    public $iteration = 1;

    public $template;

    public $page_title;

    public $district_id;

    protected $paginationTheme = 'bootstrap';

    public function export()
    {
        // return (new AduitsExport())->download('Aduits.xlsx');
    }
    public function updatedCreateNew()
    {
        // if($this->createNew = true && $this->mode != 'edit'){
        //     $this->resetInputs();
        // }
      
        // $this->mode = 'add';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function cancel()
    {
        $this->mode = 'add';
        $this->createNew = false;
        $this->delete_id = '';
        $this->edit_id = '';
        $this->resetInputs();
    }


    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $data['districts'] = District::where('is_active',1)->get();
        $data['meter_types'] = MeterType::where('is_active',1)->get();
        $data['zones'] = Zone::where('is_active',1)  ->when($this->district_id, function ($query) {
            $query->where('district_id', $this->district_id);
        })->get();
        $data['feeders'] = Feeder::where('is_active',1)->get();
        $data['audits'] = Aduit::search($this->search)->with(['district','zone'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->where('status','!=','Pending')
        ->paginate($this->perPage);
        return view('livewire.management.official-audits-component',$data);
    }
}
