<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestCommission extends Model
{
    use HasFactory;
    public $table ="interest_commission";
    protected $guarded = [];
    public $timestamps = 'false';
}
