<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsWithCustomers extends Model
{
    use HasFactory;
    protected $table = "jobs_with_customers";
    // protected $fillable = ""

    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}
