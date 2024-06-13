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
        $applied_customers = JobStatus::whereIn('job_id',$jobs_created)->with('customers','jobs')->latest()->get();
        $active = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 0)->count();
        $awaited = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 1)->count();
        $reviewed = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 2)->count();
        $contacted = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 3)->count();
        $hired = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 4)->count();
        // dd($hired);
        $rejected = CustomerStatus::whereIn('job_id',$jobs_created)->where('status', 5)->count();
        $status = [
            'active' => $active,
            'awaited' => $awaited,
            'reviewed' => $reviewed,
            'contacted' => $contacted,
            'hired' => $hired,
            'rejected' => $rejected,
            ];
            // dd('gere');
        $jobs = Jobs::where('user_id',$user->id)->select('job_title', 'id')->get(); 
        return Inertia::render('Business/Welcome',compact('footer_data','user','applied_customers','status','jobs'));
    }

    public function customer_dash(){
        $footer_data = FooterData::first();
        return Inertia::render('Customer/Welcome',compact('footer_data'));
    }
    
}
