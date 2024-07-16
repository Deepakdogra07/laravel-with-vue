<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Mail\Transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        Mail::to('business@yopmail.com')->send(new Transaction('2' , 'alka', 'alkavisionvivante@gmail.com','tdgdfgfgdf','1','0','SUCCED'));
    }
}
