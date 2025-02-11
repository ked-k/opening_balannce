<?php

namespace App\Models\Management;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aduit extends Model
{
    use HasFactory;
    public $fillable =[
        'purpose',
        'location',
        'district_id',
        'zone_id',
        'feeder_id',
        'meter_type_id',
        'meter_number',
        'customer',
        'customer_contact',
        'anomaly',
        'customer_ref_no',
        'supply_type',
        'created_by', 
        'business_type',      
        'anomaly_image',
        'clamp_on_reading',
        'ciu_reading',
        'average_consamption',
        'total_consumption',
        'test_interpretation',
        'action_taken',
        'reseon_left_on',
        'remarks',
        'police_letter_image',
        'box_image',
        'house_image',
        'date_received',
        'received_by',
        'receiver_action',
        'receiver_comment',
        'status',
        'taken_by',
        'service_oder_no',
        'result',
        'new_meter_no',
        'issued_to',
        'date_issued',
        'date_completed',
        'energy_recovery',
        'amount_paid',
        'meter_charge',
        'proof_of_payement'
    ];
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
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }  
    public function meterType()
    {
        return $this->belongsTo(MeterType::class, 'meter_type_id', 'id');
    }  
    public function feeder()
    {
        return $this->belongsTo(Feeder::class, 'feeder_id', 'id');
    }  
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }   
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    } 
    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by', 'id');
    }
    public function issuedTo()
    {
        return $this->belongsTo(User::class, 'issued_to', 'id');
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
               ->orWhere('customer_ref_no', 'like', '%'.$search.'%')
               ->orWhere('customer', 'like', '%'.$search.'%')
               ->orWhere('customer_contact', 'like', '%'.$search.'%')
               ->orWhereHas('district', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
    }
}
