<?php

namespace App\Models;

use App\Models\CustomerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers_personal_details";
    protected $fillable = [
        'id',
        'user_id',
        'job_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number'.
        'confirm_email',
        'date_of_birth',
        'country_of_birth',
        'city_of_birth',
        'martial_status',
        'gender',
        'migrate_country',
        'customer_image',
        'passport_number',
        'passport_image',
        'issuing_authority',
        'date_of_expiry',
        'citizen_of_more_than_one_country',
        'visa_available',
        'date_of_travel',
        'created_at',
        'updated_at'
    ];

    public function jobs(){
        return $this->belongsTo(Jobs::class,'job_id','id');
    }
    public function status(){
        return $this->belongsTo(CustomerStatus::class,'customer_id');
    }

    public function statuz(){
        return $this->hasOne(CustomerStatus::class,'customer_id');
    }
    public function travel_details(){
        return $this->hasone(CustomerTravelDetails::class,'customer_id');
    }
    public function documents(){
        return $this->hasone(CustomerDocuments::class,'customer_id');
    }
    public function employments(){
        return $this->hasone(CustomerTraining::class,'customer_id');
    }
    public function transactions(){
        return $this->hasone(Transactions::class,'customer_id');
    }
    
}
