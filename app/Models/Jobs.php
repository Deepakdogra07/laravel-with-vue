<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $table = "jobs";
    protected $fillable = ['job_title','job_description','position_id','seniority_id','discipline_id','work_experience_id','skills_id','remote_work','industry_id','segment','positions','pin_code','state','pay_range','job_start_date','application_link'];

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
        return $this->hasOne(Discipline::class,'id','industry_id');
    }
    public function seniority(){
        return $this->hasOne(Seniorities::class,'id','industry_id');
    }
    public function skills(){
        return $this->hasMany(Skills::class,'id',json_decode('skills'));
    }
    public function createdby(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
}
