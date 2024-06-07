<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobStatus extends Model
{
    use HasFactory;
    protected $table = 'jobs_with_customer_status';

    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }
    public function jobs(){
        return $this->hasOne(Jobs::class,'id','job_id');
    }
}
