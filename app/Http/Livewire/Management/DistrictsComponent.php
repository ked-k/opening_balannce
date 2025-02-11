<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\District;

class DistrictsComponent extends Component
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

    public $iteration = 1;

    public $template;

    public $page_title;

    protected $paginationTheme = 'bootstrap';

    public function export()
    {
        // return (new districtsExport())->download('districts.xlsx');
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
            'name' => 'required|unique:districts',
            'is_active'=>'required',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:districts',
            'is_active'=>'required',
        ]);

        $District = new District();
        $District->name = $this->name;
        $District->is_active = $this->is_active;
        $District->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District created successfully!']);
    }
    public function editData(District $District)
    {
        $this->edit_id = $District->id;
        $this->name = $District->name;
        $this->is_active = $District->is_active;
        $this->mode = 'edit';
        //$this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active']);
        $this->mode = 'add';
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:districts,name,'.$this->edit_id.'',
        ]);

        $District = District::find($this->edit_id);
        $District->name = $this->name;
        $District->is_active = $this->is_active;
        $District->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'District updated successfully!']);
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
        $data['districts'] = District::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.management.districts-component',$data);
    }
}
