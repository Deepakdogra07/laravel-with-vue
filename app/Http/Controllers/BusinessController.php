<?php

namespace App\Http\Controllers;

use App\Models\JobStatus;
use DateTime;
use App\Models\Jobs;
use Inertia\Inertia;
use App\Models\Skills;
use App\Rules\MaxWords;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Language;
use App\Models\Position;
use App\Models\Discipline;
use App\Models\FooterData;
use App\Models\Industries;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\CustomerStatus;
use App\Models\Workexperience;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;

class BusinessController extends Controller
{
    public function index()
    {
        $jobs = Jobs::where('user_id', Auth::user()->id)->with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills')->latest()->get();   //Get data for particular business
        $footer_data = FooterData::first();
        $positions = Position::all();
        $industries = Industries::all();
        $disciplines = Discipline::all();
        $seniorities = Seniorities::all();
        return Inertia::render('Business/Index', compact('disciplines','industries', 'seniorities','positions', 'jobs', 'footer_data'));

    }
    public function create()
    {
        $positions = Position::all();
        $skills = Skills::all();
        $industries = Industries::all();
        $disciplines = Discipline::all();
        $seniorities = Seniorities::all();
        $work_experience = Workexperience::all();
        $languages = Language::select('id', 'language_name as name')->get();
        $currencies = DB::table('currencies')->get();
        return Inertia::render('Business/Create', compact('currencies', 'languages', 'positions', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience'));
    }
    public function store(Request $request)
    {
// dd($request->all());
        $rules = [
            "job_title" => 'required',
            "job_image" => 'required|max:20480',
            "job_description" => 'required',
            "posting_summary" => ['required', new MaxWords(30)],
            // "detail" => ['required', new MaxWords(30)],
            "conditions" => ['required', new MaxWords(30)],
            "requirements" => ['required', new MaxWords(30)],
            "language_id" => 'required',
            "position_id" => 'required',
            "seniority_id" => 'required',
            "discipline_id" => 'required',
            "work_experience_id" => 'required',
            "skills_id" => 'required',
            "industry_id" => 'required',
            "positions" => 'required',
            "pin_code" => 'required',
            "city" => 'required',
            "segment" => 'required',
            "job_country" => 'required',
            "job_start_date" => 'required',
            'recommended_skills'=>'required'

        ];

        $messages = [
            'position_id.required' => 'Position type is required.',
            'seniority_id.required' => 'Seniority  is required.',
            'discipline_id.required' => 'Discipline  is required.',
            'work_experience_id.required' => 'Overall work experience  is required.',
            'skills_id.required' => 'Skills  are required.',
            'language_id.required' => 'Language  is required.',
            'industry_id.required' => 'Industry  is required.',
            'job_country.required' => 'Country  is required.',
            'posting_summary.required' => 'Job posting summary  is required.',
            'job_description.required' => 'Details of the job  is required.',
            'pin_code.required' => 'Zip Code  is required.',
            'job_image.required' => 'Job Image  is required.',
            'positions.required' => 'Position  is required.',
            'segment.required' => 'Segment  is required.',
            'job_title.required' => 'Job title  is required.',
            'conditions.required' => 'Conditions  is required.',
            'requirements.required' => 'Requirements  is required.',
            'job_image.max' => 'Job Image should be less than 20MB.',
            'job_start_date.required' => 'Job start date  is required.',
            'recommended_skills.required' => 'Please select atleast one recommended skill.'
   
        ];
        if (isset($request->min_pay_range)  || isset($request->max_pay_range) || isset($request->currency_id)) {
            $rules = [
                'min_pay_range' => 'required|numeric|gt:0',
                'max_pay_range' => 'required|numeric|gt:' . $request->min_pay_range,
                'currency_id' => 'required',
            ];
            $messages = [
                'min_pay_range.required' => 'Minimum salary is required.',
                'min_pay_range.numeric' => 'Minimum salary must be number.',
                'max_pay_range.numeric' => 'Maximum salary must be number.',
                'min_pay_range.gt' => 'Minimum salary must be greater than 0.',
                'max_pay_range.required' => 'Maximum salary is required.',
                'max_pay_range.gt' => 'Maximum salary must be greater than the minimum salary.',
                'currency_id.required' => 'Currency is required.',
            ];
         }
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        try {
            $skills = [];
            $languages = [];
            $industries = [];
            foreach ($request->skills_id as $skill) {
                $skills[] = $skill['id'];
            }
            foreach ($request->language_id as $language) {
                $languages[] = $language['id'];
            }
            foreach ($request->industry_id as $industry) {
                $industries[] = $industry['id'];
            }
            $skills = json_encode($skills);
            $languages = json_encode($languages);
            $industries = json_encode($industry);
            $job = new Jobs();
            $job->fill($request->except('skills_id'));
            $job->skills_id = $skills;
            $job->industry_id = $industries;
            $job->language_id = $languages;
            $job->recommended_skills = json_encode($request->recommended_skills);
            if ($request->hasFile('job_image')) {
                $image = $request->file('job_image');
                $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('jobs/' . $name, file_get_contents($image));
                $job->job_image = '/storage/jobs/' . $name;
            }
            $job->user_id = auth()->user()->id;
            $job->save();
        } catch (\Exception $e) {
            return back()->withErrors(['success' => false, 'message' => $e->getMessage()]);
        }

        return to_route('business-jobs.index');
    }
    public function edit($id)
    {
        $positions = Position::all();
        $skills = Skills::all();
        $industries = Industries::all();
        $disciplines = Discipline::all();
        $seniorities = Seniorities::all();
        $work_experience = Workexperience::all();
        $currencies = Currency::all();
        $job = Jobs::where('id', $id)->first();
        $languages = Language::select('id', 'language_name as name')->get();
        return Inertia::render('Business/Edit', compact('positions', 'currencies', 'languages', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience', 'job'));
    }
    public function update($id, Request $request)
    {
        $rules = [
            "job_title" => 'required',
            "job_image" => 'required|max:20480',
            "job_description" => 'required',
            "posting_summary" => ['required', new MaxWords(30)],
            // "detail" => ['required', new MaxWords(30)],
            "conditions" => ['required', new MaxWords(30)],
            "requirements" => ['required', new MaxWords(30)],
            "language_id" => 'required',
            "position_id" => 'required',
            "seniority_id" => 'required',
            "discipline_id" => 'required',
            "work_experience_id" => 'required',
            "skills_id" => 'required',
            "industry_id" => 'required',
            "positions" => 'required',
            "pin_code" => 'required',
            "city" => 'required',
            "segment" => 'required',
            "job_country" => 'required',
            "job_start_date" => 'required',
            'recommended_skills'=>'required'

        ];

        $messages = [
            'position_id.required' => 'Position type is required.',
            'seniority_id.required' => 'Seniority  is required.',
            'discipline_id.required' => 'Discipline  is required.',
            'work_experience_id.required' => 'Overall work experience  is required.',
            'skills_id.required' => 'Skills  is required.',
            'language_id.required' => 'Language  is required.',
            'industry_id.required' => 'Industry  is required.',
            'job_country.required' => 'Country  is required.',
            'posting_summary.required' => 'Job posting summary  is required.',
            'job_description.required' => 'Details of the job  is required.',
            'pin_code.required' => 'Zip Code  is required.',
            'job_image.required' => 'Job Image  is required.',
            'positions.required' => 'Positions  is required.',
            'segment.required' => 'Segment  is required.',
            'job_title.required' => 'Job title  is required.',
            'conditions.required' => 'Conditions  is required.',
            'requirements.required' => 'Requirements  is required.',
            'job_image.max' => 'Job Image should be less than 20MB.',
            'job_start_date.required' => 'Job start date  is required.',
            'recommended_skills.required' => 'Please select atlease one of the recommended skills.'
   
        ];
        if (isset($request->min_pay_range)  || isset($request->max_pay_range) || isset($request->currency_id)) {
            $rules = [
                'min_pay_range' => 'required|numeric|gt:0',
                'max_pay_range' => 'required|numeric|gt:' . $request->min_pay_range,
                'currency_id' => 'required',
            ];
            $messages = [
                'min_pay_range.required' => 'Minimum salary is required.',
                'min_pay_range.numeric' => 'Minimum salary must be number.',
                'max_pay_range.numeric' => 'Maximum salary must be number.',
                'min_pay_range.gt' => 'Minimum salary must be greater than 0.',
                'max_pay_range.required' => 'Maximum salary is required.',
                'max_pay_range.gt' => 'Maximum salary must be greater than the minimum salary.',
                'currency_id.required' => 'Currency is required.',
            ];
         }
        $validate = Validator::make($request->all(), $rules, $messages);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        try {
            $skills = [];
            $languages = [];
            $industries = [];
            foreach ($request->skills_id as $skill) {
                $skills[] = $skill['id'];
            }
            foreach ($request->language_id as $language) {
                $languages[] = $language['id'];
            }
            foreach ($request->industry_id as $industry) {
                $industries[] = $industry['id'];
            }
            $skills = json_encode($skills);
            $industries = json_encode($industries);
            $languages = json_encode($languages);
            $job = Jobs::findOrFail($id);
            $job->fill($request->except('skills_id'));
            $job->skills_id = $skills;
            $job->language_id = $languages;
            $job->industry_id = $industries;
            $job->recommended_skills = json_encode($request->recommended_skills);
            if ($request->hasFile('job_image')) {
                if (public_path($job->job_image)) {
                    $imagePath = substr($job->job_image, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                }

                $image = $request->file('job_image');
                $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('jobs/' . $name, file_get_contents($image));
                $job->job_image = '/storage/jobs/' . $name;
            }
            $job->user_id = auth()->user()->id;
            $job->update();
        } catch (\Exception $e) {
            return back()->withErrors(['success' => false, 'message' => $e->getMessage()]);
        }

        return to_route('business-jobs.index');
    }
    public function show($id)
    {
        $job = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby', 'business')->where('id', $id)->first();
        $applied_customers = Customer::where('job_id', $id)->get();
        $languages = Language::select('id', 'language_name as name')->get();
        $skills = Skills::all();
        $industries = Industries::all();
        $created_time = $this->date_Time($job->created_at);
        return Inertia::render('Business/Show', compact('job', 'industries', 'languages', 'skills', 'applied_customers', 'created_time'));
    }



    public function destroy($id)
    {
        $job = Jobs::findOrFail($id);
        $job->forceDelete();
        return to_route('jobs.index');
    }
    private function date_Time($created_at)
    {
        $current_datetime = new DateTime(); // Current date and time
        $job_created_at = new DateTime($created_at); // Job creation date and time

        // Calculate the difference
        $interval = $current_datetime->diff($job_created_at);
        $time = '';
        if ($interval->d > 0) {
            $time = $interval->d . ' days ago';
        } elseif ($interval->h > 0) {
            $time = $interval->h . ' hours ago';
        } elseif ($interval->i > 0) {
            $time = $interval->i . ' minutes ago';
        } else {
            $time = 'Just now';
        }
        return $time;
    }

    public function job_for_customer($job_id)
    {
        $applied_customers = JobStatus::whereIn('job_id',$job_id)->with('customers')->get();
        $active = CustomerStatus::where('job_id', $job_id)->where('status', 0)->count();
        $awaited = CustomerStatus::where('job_id', $job_id)->where('status', 1)->count();
        $reviewed = CustomerStatus::where('job_id', $job_id)->where('status', 2)->count();
        $contacted = CustomerStatus::where('job_id', $job_id)->where('status', 3)->count();
        $hired = CustomerStatus::where('job_id', $job_id)->where('status', 4)->count();
        $rejected = CustomerStatus::where('job_id', $job_id)->where('status', 5)->count();
        $status = [
            'active' => $active,
            'awaited' => $awaited,
            'reviewed' => $reviewed,
            'contacted' => $contacted,
            'hired' => $hired,
            'rejected' => $rejected,
        ];
        return Inertia::render('Business/ViewCustomers', compact('applied_customers', 'job_id', 'status'));
    }
    public function customer_filteration($status)
    {
        $user_id = Auth::user()->id;
        $job_id = Jobs::where('user_id',$user_id)->pluck('id')->toArray();
        
        $applied_customers = JobStatus::where('status',$status)->whereIn('job_id',$job_id)->with('customers','jobs')->get();
        // dd($applied_customers);
        return response()->json(['applied_customers' => $applied_customers]);
    }
    public function customer_search($string)
    {
        $user_id = Auth::user()->id;
        $job_id = Jobs::where('user_id',$user_id)->pluck('id')->toArray();
        
        $applied_customers = JobStatus::whereIn('jobs_with_customer_status.job_id',$job_id)
        ->whereHas('customers', function ($query) use ($string) {
            $query->where('first_name', 'like', "%{$string}%");
        })
        ->orwhereHas('jobs', function ($query) use ($string) {
            $query->where('job_title', 'like', "%{$string}%");
        })->with('customers','jobs')->get();
        return response()->json(['applied_customers' => $applied_customers]);
    }
    public function jobs_search($string){
        $jobs = Jobs::where('user_id', Auth::user()->id)->where('job_title','like',"%$string%")->with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills')->latest()->get(); 
        return response()->json(['jobs' => $jobs]);

    }

    public function change_status(Request $request){
         $data = JobStatus::where(['customer_id'=>$request->customer_id,'job_id'=>$request->job_id])->update(['status'=>$request->status]);
        if($data){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
    public function view_customer($customer_id){
        $customer = Customer::where('id',$customer_id)->with('travel_details','documents','employments')->first();
        // $customer_documents = \App\Models\CustomerDocuments::where('customer_id',$customer_id)->first();
        // dd($customer);
        return Inertia::render('Business/ViewCustomer',compact('customer'));
    }
}
