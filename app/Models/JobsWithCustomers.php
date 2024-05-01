<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsWithCustomers extends Model
{
    use HasFactory;
    protected $table = "customers_with_jobs";

    public function customers(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }
}
