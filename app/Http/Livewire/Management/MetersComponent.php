<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\MeterType;

class MetersComponent extends Component
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
        // return (new meter_typesExport())->download('meter_types.xlsx');
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
            'name' => 'required|unique:meter_types',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:meter_types',
            'is_active'=>'required',
        ]);

        $MeterType = new MeterType();
        $MeterType->name = $this->name;
        $MeterType->is_active = $this->is_active;
        $MeterType->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'MeterType created successfully!']);
    }
    public function editData(MeterType $MeterType)
    {
        $this->edit_id = $MeterType->id;
        $this->name = $MeterType->name;
        $this->is_active = $MeterType->is_active;
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
            'name' => 'required|unique:meter_types,name,'.$this->edit_id.'',
        ]);

        $MeterType = MeterType::find($this->edit_id);
        $MeterType->name = $this->name;
        $MeterType->is_active = $this->is_active;
        $MeterType->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'MeterType updated successfully!']);
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
        $data['meter_types'] = MeterType::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.management.meters-component', $data);
    }
}
