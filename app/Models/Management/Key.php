<?php

namespace App\Models\Management;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Key extends Model
{
    use HasFactory;

    protected $fillable=[
        'feeder',
        'meter_number',
        'location',
        'customer',
        'account_no',
        'padlock_no',
        'anomaly',
        'hook_no',
        'box_no',
        'type',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logFillable()
        ->useLogName('Keys')
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }


    public function feeder()
    {
        return $this->hasMany(Zone::class, 'feeder', 'name');
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
               ->where('meter_number', 'like', '%'.$search.'%')
               ->orWhere('meter_number', 'like', '%'.$search.'%')
               ->orWhere('customer', 'like', '%'.$search.'%')
               ->orWhere('account_no', 'like', '%'.$search.'%')
               ->orWhere('padlock_no', 'like', '%'.$search.'%')
               ->orWhere('box_no', 'like', '%'.$search.'%');
    }
}
