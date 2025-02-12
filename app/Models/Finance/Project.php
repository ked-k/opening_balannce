<?php

namespace App\Models\Finance;

use App\Models\Finance\FmsTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;

    public function requestable(): MorphTo
    {
        return $this->morphTo();
    }

    public function transactions()
    {
        return $this->hasMany(FmsTransaction::class, 'project_id', 'id');
    }
    public function getCurrentBalance($startDate = null, $endDate = null)
    {
        $debitTotal = $this->transactions()->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('trx_date', [$this->startDate, $this->endDate]);
        })->where('trx_type', 'Income')->sum('amount_local');
        $creditTotal = $this->transactions()->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('trx_date', [$this->startDate, $this->endDate]);
        })->where('trx_type', 'Expense')->sum('amount_local');
        return $debitTotal - $creditTotal;
    }
    protected $fillable = [
        'project_type',
        'project_category',
        'project_code',
        'name',
        'funding_amount',
        'grant_code',
        'currency_id',
        'start_date',
        'end_date',
        'fa_percentage_fee',
        'project_summary',
        'progress_status',
        'merp_id',
        'funding_source',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Projects')
            ->dontLogIfAttributesChangedOnly(['updated_at', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    public function mous()
    {
        return $this->hasMany(ProjectMou::class, 'project_id', 'id');
    }

    public function fundingBalance()
    {
        return $this->mous()->sum('funding_amount');
    }
    protected $guarded = ['id'];
    // public function requests(): MorphMany
    // {
    //     return $this->morphMany(Request::class, 'requestable');
    // }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('project_code', 'like', '%' . $search . '%')
            ->orWhere('project_category', 'like', '%' . $search . '%')
            ->orWhere('project_type', 'like', '%' . $search . '%')
            ->orWhere('name', 'like', '%' . $search . '%')
            ->orWhere('grant_code', 'like', '%' . $search . '%');
    }
}
