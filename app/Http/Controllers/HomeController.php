<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\Logo;
use Inertia\Inertia;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Customer;
use App\Models\JobStatus;
use App\Models\FooterData;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\CustomerStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $message = session('message');
        session()->forget('message');
        session()->forget('success');
        $sliders = Slider::all();
        $logo = Logo::first();
        $categories = Category::where('status',1)->get();
        $footer_data = FooterData::first();
        if(!$footer_data){
            return redirect()->route('login');
        }
        return Inertia::render('Welcome',compact('sliders',"logo","categories","footer_data",'message'));
    }
    public function business_dash(){
        $footer_data = FooterData::first();
        $user = Auth::user();
        $jobs_created = Jobs::where('user_id',$user->id)->pluck('id')->toArray(); 
        $applied_customers = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->with('customers','jobs','customers.travel_details')->latest()->get();
        $active = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 0)->count();
        $awaited = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 1)->count();
        $reviewed = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 2)->count();
        $contacted = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 3)->count();
        $hired = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 4)->count();
        // dd($hired);
        $rejected = JobStatus::whereIn('job_id',$jobs_created)->whereHas('customers', function ($query) {
            $query->where('submitted',1); 
        })->where('status', 5)->count();
        $status = [
            'all' => count($applied_customers),
            'active' => $active,
            'awaited' => $awaited,
            'reviewed' => $reviewed,
            'contacted' => $contacted,
            'hired' => $hired,
            'rejected' => $rejected,
            ];
        $jobs = Jobs::where('user_id',$user->id)->select('job_title', 'id')->get(); 
        return Inertia::render('Business/Welcome',compact('footer_data','user','applied_customers','status','jobs'));
    }

    public function customer_dash(){
        if(Auth::user()->user_type < 3){
            return redirect()->route('business-dash');
        }
        $footer_data = FooterData::first();
       
        $applied_jobs = JobStatus::whereHas('customers', function ($query) {
            $query->where('user_id',Auth::user()->id)->where('submitted',1); 
        })->with('customers','jobs','jobs.business','customers.travel_details')->latest()->get();
        return Inertia::render('Customer/Welcome',compact('footer_data','applied_jobs'));
    }
    
}
