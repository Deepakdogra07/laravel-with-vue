<?php

namespace App\Http\Controllers;

use ZipArchive;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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

    public function downloadZip($customer_id){
        try{

            $zip = new ZipArchive;
            $customer = Customer::where('id',$customer_id)->with('travel_details','documents','employments')->first();
            $fileName = "$customer->first_name$customer->last_name.zip";
    
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
            {
                
                $files = [
                    'customer_image' => $customer->customer_image, 
                    'passport_image' => $customer->passport_image, 
                    'employer_statement' => $customer->employments->employer_statement, 
                    'financial_evidence' => $customer->employments->financial_evidence, 
                    'evidence_self_employment' => $customer->employments->evidence_self_employment, 
                    'self_employment_aus' => $customer->employments->evidence_self_employment_aus, 
                    'formal_training_evidence' => $customer->employments->formal_training_evidence, 
                    'employment_evidence' => $customer->documents->employment_evidence, 
                    'licences' => $customer->documents->licences, 
                    'kitchen_area' => $customer->documents->kitchen_area, 
                    'ingredients' => $customer->documents->ingredients, 
                    'cooking_tech' => $customer->documents->cooking_tech, 
                    'clean_up' => $customer->documents->clean_up, 
                    'evidence_image' => $customer->documents->evidence_image, 
                    'resume' => $customer->documents->resume, 
                    'is_australia' => $customer->documents->is_australia, 
                ];
                    foreach ($files as $type => $filePath) {
                        // Check if the file exists
                        $absolutePath = public_path($filePath);
                        if (file_exists($absolutePath) && is_file($filePath)) {
                            $zip->addFile($absolutePath, $type);
                        }
                    }
                $zip->close();
            }
    
            
                return response()->download($filePath)->deleteFileAfterSend(true);
            
        }catch(\Exception $e){
            // return response()->json(['error'=>$e->getMessage()]);
            return redirect()->back()->with(['msg'=>$e->getMessage()]);
        }
    }
    // return response()->json(['error' => 'Unable to create ZIP file'], 500);

    
    
}
