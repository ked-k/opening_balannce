<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\Zone;
use App\Models\Management\District;

class ZonesComponent extends Component
{
    
        use WithPagination;
    
        public $perPage = 15;
    
        public $search = '';
    
        public $orderBy = 'name';
    
        public $orderAsc = true;
        public $createNew = false;
        public $name;
    
        public $is_active;
    
        public $mode = 'add';
    
        public $delete_id;
    
        public $edit_id;

        public $district_id;
    
        public $iteration = 1;
    
        public $template;
    
        public $page_title;
    
        protected $paginationTheme = 'bootstrap';
    
        public function export()
        {
            // return (new ZonesExport())->download('Zones.xlsx');
        }
        public function updatedCreateNew()
        {
            $this->resetInputs();
            $this->mode = 'add';
        }
    
        public function updatingSearch()
        {
            $this->resetPage();
        }
    
        public function mount()
        {
            $this->page_title = 'Sample Types';
        }
    
        public function updated($fields)
        {
            $this->validateOnly($fields, [
                'name' => 'required|unique:zones',
                'is_active'=>'required',
                'district_id'=>'required',
            ]);
        }
    
        public function storeData()
        {
            $this->validate([
                'name' => 'required|unique:zones',
                'is_active'=>'required',
                'district_id'=>'required',
            ]);
    
            $Zone = new Zone();
            $Zone->name = $this->name;
            $Zone->is_active = $this->is_active;
            $Zone->district_id = $this->district_id;
            $Zone->save();
    
            $this->resetInputs();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Zone created successfully!']);
        }
        public function editData(Zone $Zone)
        {
            $this->edit_id = $Zone->id;
            $this->name = $Zone->name;
            $this->is_active = $Zone->is_active;
            $this->district_id = $Zone->district_id;
            $this->mode = 'edit';
            //$this->dispatchBrowserEvent('edit-modal');
        }
    
        public function resetInputs()
        {
            $this->reset(['name', 'is_active','district_id']);
            $this->mode = 'add';
        }
    
        public function updateData()
        {
            $this->validate([
                'name' => 'required|unique:zones,name,'.$this->edit_id.'',
                'is_active'=>'required',
                'district_id'=>'required',
            ]);
    
            $Zone = Zone::find($this->edit_id);
            $Zone->name = $this->name;
            $Zone->is_active = $this->is_active;
            $Zone->district_id = $this->district_id;
            $Zone->update();
    
            $this->resetInputs();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Zone updated successfully!']);
        }
    
        public function refresh()
        {
            return redirect(request()->header('Referer'));
        }
    
        public function cancel()
        {
            $this->delete_id = '';
        }
    
        public function close()
        {
            $this->resetInputs();
        }
    
        public function render()
        {
            $data['districts'] = District::where('is_active',1)->get();
            $data['zones'] = Zone::search($this->search)->with('district')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.management.zones-component',$data);
    }
}
