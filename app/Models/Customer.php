<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customers_personal_details";

    public function jobs(){
        return $this->belongsTo(Jobs::class,'job_id','id');
    }
}
