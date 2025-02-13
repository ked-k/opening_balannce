<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\ExpenseType;
use App\Models\Finance\FmsCurrencies;
use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FmsViewProjectComponent extends Component
{
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
    public $trx_type = 'Expense';
    public $entry_type;
    public $status;
    public $description;
    public $delete_id;
    public $previous_balance;
    public $ledger_account;
    public $merpBalance = 0;
    public array $merpTransactions = [];
    public function mount($id)
    {
        $this->project_id = $id;
        $this->ledger_account = Project::where('id', $this->project_id)->first();
        $merpId = $this->ledger_account?->merp_id;
        $response = Http::get('https://merp-v2.makbrc.org/unit/ledger/' . $merpId);
        // $trxResponse = Http::get('http://merp.makbrc.online/unit/ledger/transactions/' . $this->ledger_account?->merp_id);
        try {
            $trxResponse = Http::get("https://merp-v2.makbrc.org/unit/ledger/transactions/{$merpId}");

            if ($trxResponse->successful()) {
                $data = $trxResponse->json();
                $transactions = $data['transactions'] ?? [];
                // Sort transactions by trx_date (chronological order)
                usort($transactions, function ($a, $b) {
                    return strtotime($a['trx_date']) <=> strtotime($b['trx_date']);
                });
                $this->merpTransactions = $transactions ?? [];
            } else {
                $this->merpTransactions = [];
                throw new \Exception('Failed to fetch transactions.');
            }
        } catch (\Exception $e) {
            Log::error('Transaction Fetch Error: ' . $e->getMessage());
            // return back()->with('error', 'Error fetching transactions. ' . $e->getMessage());
        }
        if ($response->successful()) {
            $data = $response->json(); // Decode the JSON response to an array
            $this->merpBalance = $data['balance'];
        } else {
            // Handle errors, if the request fails
            $this->merpBalance = 0;
        }
        // dd($this->merpTransactions);
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
            // 'project_id',
            'currency_id',
            'expense_type_id',
            // 'ledger_account',
            'trx_type',
            'entry_type',
            'status',
            'description',
        ]);
        $this->editMode = false;

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
        $data['projects'] = Project::get();

        $data['expenseTypes'] = ExpenseType::where('type', $this->trx_type)->get();
        $data['transactions'] = FmsTransaction::where('project_id', $this->project_id)->orderBy('trx_date', 'asc')->get();
        if ($this->from_date && $this->to_date) {
            // Calculate the previous balance (balance before the filtered date range)
            $this->previous_balance = FmsTransaction::where('bank_id', $this->ledger_id)
                ->where('status', '!=', 'Pending')
                ->where('trx_date', '<', $this->from_date)
                ->selectRaw("SUM(CASE WHEN trx_type = 'Income' THEN amount_local ELSE -amount_local END) as balance")
                ->value('balance') ?? 0;
        }
        return view('livewire.finance.fms-view-project-component', $data);
    }
}
