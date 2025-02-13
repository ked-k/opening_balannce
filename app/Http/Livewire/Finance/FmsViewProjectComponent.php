<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\ExpenseType;
use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FmsViewProjectComponent extends Component
{
    public $project_id;
    public $from_date;
    public $to_date;
    public $previous_balance;
    public $ledger_account;
    public $trx_type;
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
    public function render()
    {
        $data['transaction_types'] = ExpenseType::get();
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
