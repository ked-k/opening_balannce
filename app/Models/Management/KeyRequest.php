<?php

namespace App\Models\Management;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeyRequest extends Model
{
    use HasFactory;

    protected $fillable=[
        'created_by',
        'key_id',
        'reason',
        'ref_number',
        'description',
        'approved_by',
        'date_approved',
        'date_taken',
        'received_by',
        'comment',
        'status',
        'date_returned',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->logFillable()
        ->useLogName('Key Requests')
        ->dontLogIfAttributesChangedOnly(['updated_at'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    } 
    public function key()
    {
        return $this->belongsTo(Key::class, 'key_id', 'id');
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
            ->Where('request_no', $search)
            ->orWhereHas('key', function ($query) use ($search) {
                $query->orWhere('box_no', 'like', '%'.$search.'%');
            })
            ->orWhereHas('key', function ($query) use ($search) {
                $query->Where('padlock_no', 'like', '%'.$search.'%');
            })
            ->orWhereHas('key', function ($query) use ($search) {
                $query->Where('customer', 'like', '%'.$search.'%');
            })
            ->orWhereHas('key', function ($query) use ($search) {
                $query->where('meter_number', 'like', '%'.$search.'%');
            });
    }
}
