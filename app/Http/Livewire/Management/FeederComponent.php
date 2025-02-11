<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Management\Feeder;

class FeederComponent extends Component
{
    use WithPagination, WithFileUploads;

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
        // return (new FeedersExport())->download('Feeders.xlsx');
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
            'name' => 'required|unique:feeders',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|unique:feeders',
            'is_active'=>'required',
        ]);

        $Feeder = new Feeder();
        $Feeder->name = $this->name;
        $Feeder->is_active = $this->is_active;
        $Feeder->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Feeder created successfully!']);
    }
    public function editData(Feeder $Feeder)
    {
        $this->edit_id = $Feeder->id;
        $this->name = $Feeder->name;
        $this->is_active = $Feeder->is_active;
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
            'name' => 'required|unique:feeders,name,'.$this->edit_id.'',
        ]);

        $Feeder = Feeder::find($this->edit_id);
        $Feeder->name = $this->name;
        $Feeder->is_active = $this->is_active;
        $Feeder->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Feeder updated successfully!']);
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
        $data['feeders'] = Feeder::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.management.feeder-component',$data);
    }
}
