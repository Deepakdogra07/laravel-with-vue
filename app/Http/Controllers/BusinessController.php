<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Inertia\Inertia;
use App\Models\FooterData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
   public function index(){
    $jobs = Jobs::where('user_id',Auth::user()->id)->get();   //Get data for particular business
    $footer_data = FooterData::first();
    return Inertia::render('Business/Index',compact('jobs','footer_data'));

   }
}
