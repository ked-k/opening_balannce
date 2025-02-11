<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\Key;
use App\Models\Management\Feeder;

class ManangeKeysComponent extends Component
{
    use WithPagination;
    public $feeder;
    public $meter_number;
    public $location;
    public $customer;
    public $account_no;
    public $padlock_no;
    public $anomaly;
    public $hook_no;
    public $box_no;
    public $type;

    public $perPage = 15;

    public $search = '';

    public $orderBy = 'padlock_no';

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
        // return (new KeysExport())->download('Keys.xlsx');
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
            'name' => 'required|unique:Keys',
            'is_active'=>'required',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'customer'=>'required',
            'hook_no'=>'required',
            'meter_number'=>'required',
            'account_no'=>'required',
            'padlock_no'=>'required',
            'location'=>'required',
            'feeder'=>'required',
        ]);

        $Key = new Key();
        $Key->feeder = $this->feeder;
        $Key->customer = $this->customer;
        $Key->meter_number = $this->meter_number;
        $Key->account_no = $this->account_no;
        $Key->hook_no = $this->hook_no;
        $Key->padlock_no = $this->padlock_no;
        $Key->location = $this->location;
        $Key->type = 'non_amr';
        $Key->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Key created successfully!']);
    }
    public function editData(Key $Key)
    {
        $this->edit_id = $Key->id;
        $this->feeder = $Key->feeder ;
        $this->account_no= $Key->account_no;
        $this->customer= $Key->customer;
        $this->meter_number= $Key->meter_number;
        $this->hook_no = $Key->hook_no ;
        $this->padlock_no = $Key->padlock_no;
        $this->location = $Key->location;
        $this->mode = 'edit';
        //$this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active',
        'feeder',
        'meter_number',
        'location',
        'customer',
        'account_no',
        'padlock_no',
        'anomaly',
        'hook_no',
        'box_no',
        'type',
    ]);
        $this->mode = 'add';
    }

    public function updateData()
    {
        $this->validate([
            'customer'=>'required',
            'hook_no'=>'required',
            'meter_number'=>'required',
            'account_no'=>'required',
            'box_no'=>'required',
            'location'=>'required',
            'feeder'=>'required',
        ]);

        $Key = Key::find($this->edit_id);
        $Key->feeder = $this->feeder;
        $Key->customer = $this->customer;
        $Key->meter_number = $this->meter_number;
        $Key->account_no = $this->account_no;
        $Key->hook_no = $this->hook_no;
        $Key->padlock_no = $this->padlock_no;
        $Key->location = $this->location;
        $Key->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Key updated successfully!']);
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
        $data['keys'] = Key::search($this->search)->where('type','non_amr')
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        $data['feeders'] = Feeder::where('is_active',1)->get();
        return view('livewire.management.manange-keys-component', $data);
    }
}
