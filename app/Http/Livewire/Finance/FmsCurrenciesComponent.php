<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\FmsCurrencies;
use Livewire\Component;
use Livewire\WithPagination;

class FmsCurrenciesComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $currencyIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $is_active = 1;

    public $system_default = 0;

    public $code;

    public $exchange_rate = 1;

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
            'code' => 'required|string',
            'system_default' => 'required|integer',
            'exchange_rate' => 'required|numeric',
        ]);
    }

    public function storeFmsCurrency()
    {
        $this->validate([
            'name' => 'required|string|unique:fms_currencies',
            'is_active' => 'required|numeric',
            'code' => 'required|string',
            'system_default' => 'required|integer',
            'exchange_rate' => 'required|numeric',

        ]);

        if ($this->system_default == false) {
            $exRate = $this->exchange_rate;
        } else {
            $exRate = 1;
        }

        $currency = new FmsCurrencies();
        $currency->name = $this->name;
        $currency->is_active = $this->is_active;
        $currency->code = $this->code;
        $currency->exchange_rate = $exRate;
        $currency->system_default = $this->system_default;
        $currency->save();
        if ($this->system_default == 1) {
            FmsCurrencies::where('id', '!=', $currency->id)->update(['system_default' => '0']);
        }
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'currency created successfully!']);
    }

    public function editData(FmsCurrencies $currency)
    {
        $this->edit_id = $currency->id;
        $this->name = $currency->name;
        $this->code = $currency->code;
        $this->is_active = $currency->is_active;
        $this->system_default = $currency->system_default;
        $this->exchange_rate = $currency->exchange_rate;
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
        $this->reset(['name', 'is_active', 'system_default', 'code', 'exchange_rate']);
    }

    public function updateFmsCurrency()
    {
        $this->validate([
            'name' => 'required|unique:fms_currencies,name,' . $this->edit_id . '',
            'is_active' => 'required|numeric',
            'code' => 'required|string',
            'system_default' => 'required|integer',
            'exchange_rate' => 'required|numeric',
        ]);
        if ($this->system_default == false) {
            $exRate = $this->exchange_rate;
        } else {
            $exRate = 1;
        }

        $currency = FmsCurrencies::find($this->edit_id);
        $currency->name = $this->name;
        $currency->exchange_rate = $exRate;
        $currency->code = $this->code;
        $currency->is_active = $this->is_active;
        $currency->system_default = $this->system_default;
        $currency->update();

        // if($currency->system_default !=1){
        //     FmsCurrency::where('id', '!=', $currency->id)->update(['system_default'=>'0']);
        // }
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'currency updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->currencyIds) > 0) {
            // return (new currenciesExport($this->currencyIds))->download('currencies_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No currencies selected for export!',
            ]);
        }
    }

    public function filterCurrencies()
    {
        $currencies = FmsCurrencies::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->currencyIds = $currencies->pluck('id')->toArray();

        return $currencies;
    }

    public function render()
    {
        $data['currencies'] = $this->filterCurrencies()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.finance.fms-currencies-component', $data);
    }
}
