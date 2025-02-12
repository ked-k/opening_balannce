<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\ExpenseType;
use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use Livewire\Component;

class FmsViewProjectComponent extends Component
{
    public $project_id;
    public $from_date;
    public $to_date;
    public $previous_balance;
    public $ledger_account;
    public $trx_type;
    public function mount($id)
    {
        $this->project_id = $id;
        $this->ledger_account = Project::where('id', $this->project_id)->first();
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
