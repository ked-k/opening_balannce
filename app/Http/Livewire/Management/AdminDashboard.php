<?php

namespace App\Http\Livewire\Management;

use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use App\Models\Finance\ProjectMou;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $zone_id, $from_date, $to_date;
    public function transactions()
    {
        $data = FmsTransaction::where('entry_type', '!=', 'Bank')->with('requestable')
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        return $data;
    }
    public function render()
    {
        $data['projects'] = Project::get();
        $data['mous'] = ProjectMou::get();

        $data['transactions_chart'] = $this->transactions()
            ->selectRaw('SUM(CASE WHEN trx_type = "Income" THEN amount_local ELSE 0 END) AS total_income')
            ->selectRaw('SUM(CASE WHEN trx_type = "Expense" THEN amount_local ELSE 0 END) AS total_expense')
            ->selectRaw("DATE_FORMAT(trx_date, '%M-%Y') display_date")
            ->selectRaw("DATE_FORMAT(trx_date, '%Y-%m') new_date")
            ->groupBy('new_date')
            ->orderBy('new_date', 'ASC')
            ->get();
        $data['expenseIncome'] = $this->transactions()
            ->select('requestable_type', 'requestable_id')
            ->selectRaw('SUM(CASE WHEN trx_type = "Income" THEN total_amount*rate ELSE 0 END) AS total_income')
            ->selectRaw('SUM(CASE WHEN trx_type = "Expense" THEN total_amount*rate ELSE 0 END) AS total_expense')
            ->groupBy('requestable_type', 'requestable_id')
            ->with('requestable')
            ->get();
        $data['project_data'] = Project::select(DB::raw('count(id) as inv_count'), 'progress_status')->groupBy('progress_status')->get();
        $data['feeders'] = User::count();
        $data['districts'] = User::count();
        $data['audit_counts'] = User::get();

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('livewire.management.admin-dashboard', $data);
    }
}
