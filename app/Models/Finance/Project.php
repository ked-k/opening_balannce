<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, LogsActivity;

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
            ->orWhere('email', 'like', '%' . $search . '%');
    }
}
