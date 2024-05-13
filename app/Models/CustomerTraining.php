<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTraining extends Model
{
    use HasFactory;
    protected $table = "customers_employments";
    protected $fillable = ['employer_statement','job_id','customer_id','financial_evidence','evidence_self_employment','formal_training_evidence','created_at','updated_at'];
}
