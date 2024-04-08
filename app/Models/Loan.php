<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'status','assigned_to','applicant_name','loan_amount','installments','installments','documents_id','is_deleted'
    ];
    protected $guarded = [];
    public function documents()
    {
        return $this->hasMany(LoanDocument::class);
    }

    public function getAgent(){
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
