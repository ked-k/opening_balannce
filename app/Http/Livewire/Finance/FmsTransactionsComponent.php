<?php

namespace App\Http\Livewire\Finance;

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
    public $trx_type;
    public $entry_type;
    public $status;
    public $description;
    public function resetInputs()
    {
        $this->rest([
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

    }
    public function storeTransaction()
    {
        $this->validate([
            'trx_date' => 'required|date',
            'trx_ref' => 'required|unique:fms_transactions',
            'total_amount' => 'required',
            'coa_id' => 'required|integer',
            'bank_id' => 'required|numeric',
            'supplier_id' => 'nullable|numeric',
            'employee_id' => 'nullable|numeric',
            'rate' => 'required|numeric',
            'tax_value' => 'nullable|numeric',
            'tax_id' => 'nullable|numeric',
            'fiscal_year' => 'required|integer',
            'department_id' => 'nullable|integer',
            'project_id' => 'nullable|integer',
            'billed_project' => 'nullable|integer',
            'billed_department' => 'nullable|integer',
            'currency_id' => 'required|integer',
            'given_to' => 'required',
            'budgetExpense' => 'required',
            'ledgerExpense' => 'required',
            'budget_line_id' => 'nullable|integer',
            'ledger_account' => 'nullable|integer',
            'description' => 'required|string',
            'trx_entry_type' => 'Required',
            'bank_expense' => 'min:1',
        ]);
        $requestable = null;
        $payable = null;
        $additional_data = [];
        if ($this->entry_type == 'Project') {
            $this->validate([
                'project_id' => 'required|integer',
            ]);
            $this->department_id = null;
            $requestable = Project::find($this->project_id);
        } elseif ($this->entry_type == 'Department') {
            $this->validate([
                'department_id' => 'required|integer',
            ]);
            if ($this->department_id == 0 && $this->ledger_account == 0) {
                $requestable = CompanyProfile::latest()->first();
            } else {
                $this->project_id = null;
                $requestable = Department::find($this->department_id);
            }
        } else {
            $requestable = CompanyProfile::latest()->first();
        }
        if ($this->given_to == 'Employee') {
            $this->validate([
                'employee_id' => 'required|integer',
            ]);
            $this->supplier_id = null;
            $payable = Employee::find($this->employee_id);
            $additional_data = [
                'name' => $payable->fullName,
                'email' => $payable->email,
                'contact' => $payable->contact,
                'account_name' => $payable->account_name ?? 'N/A',
                'account' => $payable->bank_account ?? 'N/A',
                'bank' => $payable->bank_name ?? 'N/A',
            ];
        } elseif ($this->given_to == 'Provider') {
            $this->validate([
                'supplier_id' => 'required|integer',
            ]);
            $this->employee_id = null;
            $payable = Provider::find($this->supplier_id);
            $additional_data = [
                'name' => $payable->name,
                'email' => $payable->email,
                'contact' => $payable->contact,
                'account_name' => $payable->account_name ?? 'N/A',
                'account' => $payable->bank_account ?? 'N/A',
                'bank' => $payable->bank_name ?? 'N/A',
            ];
        } elseif ($this->given_to == 'Unit') {
            $this->employee_id = null;
            $this->supplier_id = null;
            $payable = FmsLedgerAccount::find($this->ledger_account);
            $additional_data = [
                'name' => $payable->name,
                'email' => null,
                'contact' => null,
                'account_name' => 'N/A',
                'account' => 'N/A',
                'bank' => 'N/A',
            ];
        }
        // dd($additional_data);
        if (!$payable) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something Went Wrong!',
                'text' => 'Please select a payee!',
            ]);
            return false;
        }
        if (!$requestable) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Something Went Wrong!',
                'text' => 'Please select a unit!',
            ]);
            return false;
        }

        try {
            DB::transaction(function () {
                $total_amount = (float) str_replace(',', '', $this->total_amount);
                $tax = 0;
                $payable = Project::where('id', $this->project_id)->first();
                // $cashAccount->update();
                $trans = new FmsTransaction();
                $trans->trx_no = $this->trx_no;
                $trans->trx_ref = $this->trx_ref;
                $trans->trx_date = $this->trx_date;
                $trans->client = $this->client;
                $trans->total_amount = $this->total_amount;
                $trans->amount_local = $this->amount_local;
                $trans->deductions = $this->deductions;
                $trans->rate = $this->rate;
                $trans->project_id = $this->project_id;
                $trans->currency_id = $this->currency_id;
                $trans->expense_type_id = $this->expense_type_id;
                $trans->ledger_account = $this->ledger_account;
                $trans->trx_type = $this->trx_type;
                $trans->entry_type = 'OP';
                $trans->status = $this->status;
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

    public function editTransaction($id)
    {
        $trans = FmsTransaction::where('id', $id)->with('requestable')->first();
        $this->edit_id = $trans->id;
        $this->trx_ref = $trans->trx_ref;
        $this->trx_date = $trans->trx_date;
        $this->rate = $trans->rate;
        $this->amount_local = $trans->amount_local;
        $this->deductions = $trans->deductions;
        $this->project_id = $trans->project_id;
        $this->currency_id = $trans->currency_id;
        $this->ledger_account = $trans->ledger_account;
        $this->entry_type = $trans->entry_type;
        $this->description = $trans->description;
        $this->total_amount = $trans->total_amount;
        $this->updatedTrxEntryType();
    }
    public function render()
    {
        return view('livewire.finance.fms-transactions-component');
    }
}
