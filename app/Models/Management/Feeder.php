<?php

namespace App\Models\Management;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feeder extends Model
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
    ];

    public function samples()
    {
        return $this->hasMany(SampleData::class, 'specimen_type', 'name');
    }   

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
               ->where('name', 'like', '%'.$search.'%');
    }
}
