<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use App\Models\Management\Key;
use App\Models\Management\KeyRequest;

class KeyRequestsComponent extends Component
{ 
    public $created_by;
    public $key_id;
    public $reason;
    public $ref_number;
    public $description;
    public $approved_by;
    public $date_approved;
    public $date_taken;
    public $received_by;
    public $status;
    public $comment;
    public $date_returned;

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

    public $find_key, $parameter;

    public $keyData;

    protected $paginationTheme = 'bootstrap';

    public function export()
    {
        // return (new KeysExport())->download('Keys.xlsx');
    }
    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->mode = 'add';
        $this->keyData = collect([]);
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
            // 'request_no'=>'required',
            'reason'=>'required',
            'ref_number'=>'required',
            'description'=>'required',
        ]);

        $Key = new Key();
        $Key->request_no = $this->feeder;
        $Key->key_id = $this->key_id;
        $Key->reason = $this->reason;
        $Key->ref_number = $this->ref_number;
        $Key->description = $this->description;
        $Key->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Key created successfully!']);
    }
    public function editData(Key $Key)
    {
        $this->edit_id = $Key->id;
        $this->key_id = $Key->key_id ;
        $this->reason= $Key->reason;
        $this->ref_number = $Key->ref_number ;
        $this->description = $Key->description;
        $this->mode = 'edit';
        //$this->dispatchBrowserEvent('edit-modal');
    }

    public function resetInputs()
    {
        $this->reset([
            'created_by',
            'key_id',
            'reason',
            'ref_number',
            'description',
            'approved_by',
            'date_approved',
            'date_taken',
            'received_by',
            'comment',
            'status',
            'date_returned',
    ]);
        $this->mode = 'add';
    }

    public function updateData()
    {
        $this->validate([
            'reason'=>'required',
            'ref_number'=>'required',
            'description'=>'required',
        ]);

        $Key = Key::find($this->edit_id);
        $Key->key_id = $this->key_id;
        $Key->reason = $this->reason;
        $Key->ref_number = $this->ref_number;
        $Key->description = $this->description;
        $Key->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Key updated successfully!']);
    }

    public function findKey()
    {
        $this->keyData = $Key= Key::where(['type',$this->description])->where($this->parameter, $this->find_key)->first();
        if($this->keyData){
            $this->key_id = $Key->id;
            $this->feeder = $Key->feeder ;
            $this->account_no= $Key->account_no;
            $this->customer= $Key->customer;
            $this->meter_number= $Key->meter_number;
            $this->hook_no = $Key->hook_no ;
            $this->padlock_no = $Key->padlock_no;
            $this->location = $Key->location;
            $this->createNew = true;
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Key found, please proceed!']);
        }else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'No key found!',
                'text' => 'Please revise your key search paramators!',
            ]);

        }
    }

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
        $data['key_requests'] = KeyRequest::search($this->search)->with(['key','user'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        return view('livewire.management.key-requests-component',$data);
    }
}
