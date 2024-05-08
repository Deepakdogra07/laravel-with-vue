<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    use HasFactory;
    protected $table="jobs_with_customer_status";

    protected $fillable =["job_id,customer_id"];
}
