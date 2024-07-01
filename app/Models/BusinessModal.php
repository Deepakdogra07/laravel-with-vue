<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessModal extends Model
{
    use HasFactory;
    protected $table= 'businesses';

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_number',
        'company_address',
        'company_country_code',
        'company_state',
        'company_city',
        'company_pin',
        'contact_department',
        'company_vat',
        'created_at',
        'updated_at'
    ];
}
