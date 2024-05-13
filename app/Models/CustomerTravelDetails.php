<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTravelDetails extends Model
{
    use HasFactory;
    protected $table = "customer_travel_details";
    protected $fillable =['job_id','customer_id','travel_details',' purpose_of_stay','type_of_visa','date_of_travel','passenger_nationality','','port_of_arrival','createda_at','updated_at'];

}
