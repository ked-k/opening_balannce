<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\ExpenseType;
use Livewire\Component;
use Livewire\WithPagination;

class FmsTrxCategoriesComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $recordIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active = 1;

    public $system_default = 0;

    public $type;

    public $description = 1;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|integer',
            'type' => 'required|string',
            'system_default' => 'required|integer',
            'description' => 'required|numeric',
        ]);
    }

    public function storeData()
    {
        $this->validate([
            'name' => 'required|string|unique:expense_types',
            'is_active' => 'required|numeric',
            'type' => 'required|string',
            'system_default' => 'required|integer',
            'description' => 'required|numeric',

        ]);

        $record = new ExpenseType();
        $record->name = $this->name;
        $record->type = $this->type;
        $record->is_active = $this->is_active;
        $record->description = $this->description;
        $record->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'record created successfully!']);
    }

    public function editData(ExpenseType $record)
    {
        $this->edit_id = $record->id;
        $this->name = $record->name;
        $this->type = $record->type;
        $this->is_active = $record->is_active;
        $this->description = $record->description;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active', 'type', 'description']);
    }

    public function updateData()
    {
        $this->validate([
            'name' => 'required|unique:expense_types,name,' . $this->edit_id . '',
            'is_active' => 'required|numeric',
            'type' => 'required|string',
            'description' => 'required|numeric',
        ]);
        if ($this->system_default == false) {
            $exRate = $this->description;
        } else {
            $exRate = 1;
        }

        $record = ExpenseType::find($this->edit_id);
        $record->name = $this->name;
        $record->description = $exRate;
        $record->type = $this->type;
        $record->is_active = $this->is_active;
        $record->update();

        // if($record->system_default !=1){
        //     Fmsrecord::where('id', '!=', $record->id)->update(['system_default'=>'0']);
        // }
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'record updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->recordIds) > 0) {
            // return (new recordExport($this->recordIds))->download('record_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No record selected for export!',
            ]);
        }
    }

    public function filterrecord()
    {
        $data = ExpenseType::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->recordIds = $data->pluck('id')->toArray();

        return $data;
    }

    public function render()
    {
        $data['expense_types'] = $this->filterrecord()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.fms-trx-categories-component', $data);
    }
}
