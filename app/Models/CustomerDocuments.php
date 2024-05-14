<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocuments extends Model
{
    use HasFactory;
    protected $table = "customers_documents_and_videos";
    protected $fillable = ['job_id','customer_id','employment_evidence','licences','kitchen_area','ingredients','dish','cooking_tech','clean_up','evidence_image','resume','','is_australia','created_at','updated_at'];
}
