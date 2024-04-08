<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_id',
        'document',
        'status',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
