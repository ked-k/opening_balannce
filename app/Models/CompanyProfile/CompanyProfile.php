<?php

namespace App\Models\CompanyProfile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyProfile extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'company_name',
        'slogan',
        'about',
        'company_type',
        'physical_address',
        'address2',
        'contact',
        'alt_contact',
        'email',
        'alt_email',
        'tin',
        'logo',
        'website',
        'fax',
        'created_by',
    ];

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
}
