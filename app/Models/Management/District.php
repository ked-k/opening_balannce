<?php

namespace App\Models\Management;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logFillable()
        ->useLogName('Feeders')
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'name',
        'is_active',
        'created_by'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class, 'district_id', 'id');
    }   
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
               ->where('name', 'like', '%'.$search.'%');
    }
}
