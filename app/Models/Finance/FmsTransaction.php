<?php

namespace App\Models\Finance;

use App\Models\Finance\ExpenseType;
use App\Models\Finance\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FmsTransaction extends Model
{
    use HasFactory;
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Transactions')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }
    public function currency()
    {
        return $this->belongsTo(FmsCurrencies::class, 'currency_id', 'id');
    }

    public function expenseLine()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public static function search($search, $type)
    {
        return empty($search) ? static::query()
        : static::query()
            ->orWhere('trx_no', $search)
            ->orWhereHas('requestable', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    if (in_array('name', Schema::getColumnListing($subQuery->getModel()->getTable()))) {
                        $subQuery->where('name', 'like', '%' . $search . '%');
                    }
                    if (in_array('first_name', Schema::getColumnListing($subQuery->getModel()->getTable()))) {
                        $subQuery->where('first_name', 'like', '%' . $search . '%');
                    }
                });
            });
    }

    protected $fillable = [
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
        'created_by',
        'updated_by',
        'requestable',
    ];
}
