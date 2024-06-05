<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\Logo;
use App\Models\FooterData;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::all();
        $logo = Logo::first();
        $categories = Category::where('status',1)->get();
        $footer_data = FooterData::first();
        if(!$footer_data){
            return redirect()->route('login');
        }
        return Inertia::render('Welcome',compact('sliders',"logo","categories","footer_data"));
    }
    public function business_dash(){
        $footer_data = FooterData::first();
        $user = Auth::user();
        $jobs_created = Jobs::where('user_id',$user->id)->pluck('id')->toArray(); 
        // $total_customers = Jobs::join('customers_personal_details','customers_personal_details.job_id','jobs.id')->count();
        $applied_customers = Customer::whereIn('job_id',$jobs_created)->with('status','jobs')->get();
        // $jobs = Jobs::where('user_id', Auth::user()->id)->with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills')->latest()->get();   //Get data for particular business
        // $footer_data = FooterData::first();
        // return Inertia::render('Business/Index',compact('jobs','footer_data'));
        
        // return Inertia::render('Business/ViewCustomers',compact('jobs','footer_data'));

        return Inertia::render('Business/Welcome',compact('footer_data','user','applied_customers'));
    }

    public function customer_dash(){
        $footer_data = FooterData::first();
        return Inertia::render('Customer/Welcome',compact('footer_data'));
    }
    
}
