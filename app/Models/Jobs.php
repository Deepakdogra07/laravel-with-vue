<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jobs extends Model
{
    use HasFactory;
    protected $table = "jobs";
    protected $fillable = [
        'job_title',
        'job_description',
        'position_id',
        'seniority_id',
        'discipline_id',
        'work_experience_id',
        'skills_id',
        'remote_work',
        'industry_id',
        'segment',
        'positions',
        'pin_code',
        'city',
        'job_country',
        'min_pay_range',
        'job_start_date',
        'max_pay_range',
        'job_image',
        'language_id',
        'posting_summary',
        'detail',
        'conditions',
        'requirements',
        'currency_id',
        'recommended_skills'];

    public function position(){
        return $this->hasOne(Position::class,'id','position_id');
    }
    public function work_experience(){
        return $this->hasOne(Workexperience::class,'id','work_experience_id');
    }
    public function industry(){
        return $this->hasOne(Industries::class,'id','industry_id');
    }
    public function discipline(){
        return $this->hasOne(Discipline::class,'id','discipline_id');
    }
    public function seniority(){
        return $this->hasOne(Seniorities::class,'id','seniority_id');
    }
    public function skills(){
        return $this->hasMany(Skills::class,'id',json_decode('skills'));
    }
    public function createdby(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function customers(){
        return $this->hasOne(Customer::class,'job_id','id');
    }

    public function customer_documents(){
        return $this->hasOne(CustomerDocuments::class,'job_id','id');
    }
    public function customer_travel_details(){
        return $this->hasOne(CustomerDocuments::class,'job_id','id');
    }
    public function customers_employments(){
        return $this->hasOne(CustomerTraining::class,'job_id','id');
    }
    public function business(){
        return $this->hasOne(BusinessModal::class,'user_id','user_id');
    }

   public function currencies(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }
}
