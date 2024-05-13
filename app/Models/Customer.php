<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers_personal_details";
    protected $fillable = ['job_id','first_name','last_name','email','confirm_email','date_of_birth','country_of_birth','city_of_birth','martial_status','gender','migrate_country','customer_image','passport_number','passport_image','issuing_authority','date_of_expiry','citizen_of_more_than_one_country','visa_available','date_of_travel','created_at','updated_at'];

    // public function jobs(){
    //     return $this->belongsTo(Jobs::class,'job_id','id');
    // }
    public function status(){
        return $this->hasone(CustomerStatus::class,'customer_id','id');
    }
    
}
