<?php

namespace App\Http\Livewire\Finance;

use App\Exports\FmsTrxExport;
use App\Models\Finance\ExpenseType;
use App\Models\Finance\FmsCurrencies;
use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FmsTransactionsComponent extends Component
{
    use WithPagination;

    //Filters
    public $exportIds;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;
    public $editMode = false;
    public $filter = false;
    public $edit_id;
    public $trx_no;
    public $trx_ref;
    public $trx_date;
    public $client;
    public $total_amount;
    public $amount_local;
    public $deductions;
    public $rate;
    public $project_id;
    public $currency_id;
    public $expense_type_id;
    public $ledger_account;
    public $trx_type = 'Expense';
    public $entry_type;
    public $status;
    public $description;
    public $delete_id;
    // public $search;

    public function export()
    {
        if (count($this->exportIds) > 0) {
            return (new FmsTrxExport($this->exportIds))->download('transactions_' . date('d-m-Y') . '_' . now()->toTimeString() . '.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something Went Wrong!',
                'text' => 'No services selected for export!',
            ]);
        }
    }
    public function mount($type)
    {
        if ($type == 'all') {
            $this->trx_type = null;
        } else {
            $this->trx_type = $type;
        }

    }
    public function close()
    {
        $this->resetInputs();
    }
    public function updatedCurrencyId()
    {
        $latestRate = FmsCurrencies::where('id', $this->currency_id)->latest()->first();

        if ($latestRate) {
            $this->rate = $latestRate->exchange_rate;
            $this->updatedTotalAmount();

        }
    }
    public function deleteTransaction($id)
    {
        FmsTransaction::where('id', $id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction deleted successfully!']);

    }
    public function updatedTotalAmount()
    {
        $total_amount = (float) str_replace(',', '', $this->total_amount);
        $rate = (float) str_replace(',', '', $this->rate);
        if (is_numeric($total_amount) && is_numeric($rate)) {
            $amount_local = $rate * $total_amount;
            $this->amount_local = round($amount_local, 2);

        }
    }
    public function resetInputs()
    {
        $this->reset([
            'trx_no',
            'trx_ref',
            'trx_date',
            'client',
            'total_amount',
            'amount_local',
            'deductions',
            'rate',
            'project_id',
            'currency_id',
            'expense_type_id',
            'ledger_account',
            'trx_type',
            'entry_type',
            'status',
            'description',
        ]);
        $this->editMode = false;

    }
    public function storeTransaction()
    {
        $this->validate([
            // 'trx_no' => 'required',
            'trx_ref' => 'required',
            'trx_date' => 'required',
            'client' => 'required',
            'total_amount' => 'required',
            'amount_local' => 'required',
            // 'deductions' => 'required',
            'rate' => 'required',
            'project_id' => 'required',
            'currency_id' => 'required',
            'expense_type_id' => 'required',
            'ledger_account' => 'nullable',
            'trx_type' => 'required',
            // 'entry_type' => 'required',
            'description' => 'required',
        ]);
        try {
            DB::transaction(function () {
                $total_amount = (float) str_replace(',', '', $this->total_amount);
                $tax = 0;
                $payable = Project::where('id', $this->project_id)->first();
                // $cashAccount->update();
                $trans = new FmsTransaction();
                $trans->trx_no = 'Trx' . time();
                $trans->trx_ref = $this->trx_ref;
                $trans->trx_date = $this->trx_date;
                $trans->client = $this->client;
                $trans->total_amount = $total_amount;
                $trans->amount_local = $this->amount_local;
                $trans->deductions = 0;
                $trans->rate = $this->rate;
                $trans->project_id = $this->project_id;
                $trans->currency_id = $this->currency_id;
                $trans->expense_type_id = $this->expense_type_id;
                $trans->ledger_account = $this->ledger_account;
                $trans->trx_type = $this->trx_type;
                $trans->entry_type = 'OP';
                $trans->description = $this->description;
                $trans->requestable()->associate($payable);
                $trans->save();

                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->entry_type = null;
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction created successfully!']);
            });
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something Went Wrong!',
                'text' => 'Transaction failed!' . $e->getMessage(),
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transaction failed!' . $e->getMessage()]);
        }
    }

    public function updateTransaction()
    {
        $this->validate([
            // 'trx_no' => 'required',
            'trx_ref' => 'required',
            'trx_date' => 'required',
            'client' => 'required',
            'total_amount' => 'required',
            'amount_local' => 'required',
            // 'deductions' => 'required',
            'rate' => 'required',
            'project_id' => 'required',
            'currency_id' => 'required',
            'expense_type_id' => 'required',
            'ledger_account' => 'nullable',
            'trx_type' => 'required',
            // 'entry_type' => 'required',
            'description' => 'required',
        ]);
        try {
            DB::transaction(function () {
                $total_amount = (float) str_replace(',', '', $this->total_amount);
                $tax = 0;
                $payable = Project::where('id', $this->project_id)->first();
                // $cashAccount->update();
                $trans = FmsTransaction::where('id', $this->edit_id)->first();
                $trans->trx_no = 'Trx' . time();
                $trans->trx_ref = $this->trx_ref;
                $trans->trx_date = $this->trx_date;
                $trans->client = $this->client;
                $trans->total_amount = $total_amount;
                $trans->amount_local = $this->amount_local;
                $trans->deductions = 0;
                $trans->rate = $this->rate;
                $trans->project_id = $this->project_id;
                $trans->currency_id = $this->currency_id;
                $trans->expense_type_id = $this->expense_type_id;
                $trans->ledger_account = $this->ledger_account;
                $trans->trx_type = $this->trx_type;
                $trans->entry_type = 'OP';
                $trans->description = $this->description;
                $trans->requestable()->associate($payable);
                $trans->save();

                $this->dispatchBrowserEvent('close-modal');
                $this->resetInputs();
                $this->entry_type = null;
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction updated successfully!']);
            });
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something Went Wrong!',
                'text' => 'Transaction failed!' . $e->getMessage(),
            ]);
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transaction failed!' . $e->getMessage()]);
        }
    }

    public function mainQuery()
    {
        $data = FmsTransaction::search($this->search)->with('requestable')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            })
            ->when($this->trx_type != '', function ($query) {
                $query->where('trx_type', $this->trx_type);
            });
        $this->exportIds = $data->pluck('id')->toArray();
        return $data;
    }

    public function editData($id)
    {
        $trans = FmsTransaction::where('id', $id)->with('requestable')->first();
        $this->edit_id = $trans->id;
        $this->trx_ref = $trans->trx_ref;
        $this->trx_date = $trans->trx_date;
        $this->rate = $trans->rate;
        $this->amount_local = $trans->amount_local;
        $this->expense_type_id = $trans->expense_type_id;
        $this->project_id = $trans->project_id;
        $this->currency_id = $trans->currency_id;
        $this->client = $trans->client;
        $this->trx_type = $trans->trx_type;
        $this->description = $trans->description;
        $this->total_amount = $trans->total_amount;
        $this->editMode = true;
    }
    public function render()
    {
        $data['expenseTypes'] = ExpenseType::where('type', $this->trx_type)->get();
        $data['projects'] = Project::get();
        $data['transactions'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.fms-transactions-component', $data);
    }
}
