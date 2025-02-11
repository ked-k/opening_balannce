<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMou extends Model
{
    use HasFactory;
    protected $fillable = [

        'funding_amount',
        'project_id',
        'is_active',
        'start_date',
        'end_date',
    ];

}
