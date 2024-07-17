<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Jobs;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Skills;
use App\Rules\MaxWords;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Language;
use App\Models\Position;
use App\Models\JobStatus;
use App\Models\Discipline;
use App\Models\Industries;
use App\Models\VideoIntro;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\CustomerStatus;
use App\Models\Workexperience;
use App\Models\CustomerTraining;
use App\Models\CustomerDocuments;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerTravelDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
   public function index()
   {
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby')->latest()->get();
      return Inertia::render('Admin/Jobs/Index', compact('jobs'));
   }
   public function create()
   {
      $positions = Position::all();
      $skills = Skills::all();
      $industries = Industries::withname();
      $disciplines = Discipline::all();
      $seniorities = Seniorities::all();
      $work_experience = Workexperience::all();
      $currencies = Currency::all();
      $languages = Language::select('id', 'language_name as name')->get();
      $employers = User::where('user_type',2)->get();
      return Inertia::render('Admin/Jobs/Create', compact('languages','employers', 'currencies', 'positions', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience'));
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
         'position_id.required' => 'The position type field is required.',
         'seniority_id.required' => 'The seniority  field is required.',
         'discipline_id.required' => 'The discipline  field is required.',
         'work_experience_id.required' => 'The overall work experience  field is required.',
         'skills_id.required' => 'The skills  field are required.',
         'language_id.required' => 'The language  field is required.',
         'industry_id.required' => 'The industry  field is required.',
         'job_country.required' => 'The country  field is required.',
         'posting_summary.required' => 'The job posting summary  field is required.',
         'job_description.required' => 'The details of the job field is required.',
         'pin_code.required' => 'The zip Code field is required.',
         'job_image.required' => 'The job Image field is required.',
         'positions.required' => 'The positions field is required.',
         'segment.required' => 'The segment field is required.',
         'job_title.required' => 'The job title field is required.',
         'conditions.required' => 'The conditions field is required.',
         'requirements.required' => 'The requirements field is required.',
         'job_image.max' => 'The job Image should be less than 20MB.',
         'job_start_date.required' => 'The job start date field is required.',
         'recommended_skills.required' => 'Please select atleast one recommended skill.'

     ];
     if (isset($request->min_pay_range)  || isset($request->max_pay_range) || isset($request->currency_id)) {
      $rules = [
          'min_pay_range' => 'required|numeric|gt:0',
          'max_pay_range' => 'required|numeric|gt:' . $request->min_pay_range,
          'currency_id' => 'required',
      ];
      $messages = [
          'min_pay_range.required' => 'The minimum salary field is required.',
          'min_pay_range.numeric' => 'The minimum salary must be number.',
          'max_pay_range.numeric' => 'The maximum salary must be number.',
          'min_pay_range.gt' => 'The minimum salary must be greater than 0.',
          'max_pay_range.required' => 'The maximum salary field is required.',
          'max_pay_range.gt' => 'The maximum salary must be greater than the minimum salary.',
          'currency_id.required' => 'The currency field is required.',
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
            $industries[] = (int)$industry['id'];
         }
         //   dd($industries);
         $skills = json_encode($skills);
         $languages = json_encode($languages);
         $industries = json_encode($industries);
         $job = new Jobs();
         $job->fill($request->except('skills_id'));
         $job->skills_id = $skills;
         $job->language_id = $languages;
         $job->industry_id = $industries;
         $job->recommended_skills = json_encode($request->recommended_skills);
         if ($request->hasFile('job_image')) {
            $image = $request->file('job_image');
            $imageName = insertData($image,'jobs/');
            $job->job_image = '/storage/' . $imageName;
         }
         if($request->employer){
            $job->user_id = $request->employer;
         }else{
            $job->user_id = auth()->user()->id;
         }

         $job->save();
      } catch (\Exception $e) {
         return back()->withErrors(['success' => false, 'message' => $e->getMessage()]);
      }
      return to_route('jobs.index');
   }
   public function edit($id)
   {
      $positions = Position::all();
      $skills = Skills::all();
      $industries = Industries::withname();
      $disciplines = Discipline::all();
      $seniorities = Seniorities::all();
      $work_experience = Workexperience::all();
      $job = Jobs::where('id', $id)->first();
      $currencies = Currency::all();
      $languages = Language::select('id', 'language_name as name')->get();
      $employers = User::where('user_type',2)->get();
      $employer_id = null;
      if(Auth::user()->id != $job->user_id){
         $employer_id = $job->user_id;
      }
      return Inertia::render('Admin/Jobs/Edit', compact('positions', 'employer_id','currencies','employers', 'languages', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience', 'job'));
   }
   public function update($id, Request $request)
   {
   //   dd($request->all());s
      $rules = [
         "job_title" => 'required',
         "job_image" => 'required|max:20480',
         "job_description" => 'required',
         "posting_summary" => ['required', new MaxWords(30)],
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
         'position_id.required' => 'The position type field is required.',
         'seniority_id.required' => 'The seniority  field is required.',
         'discipline_id.required' => 'The discipline  field is required.',
         'work_experience_id.required' => 'The overall work experience  field is required.',
         'skills_id.required' => 'The skills  field are required.',
         'language_id.required' => 'The language  field is required.',
         'industry_id.required' => 'The industry  field is required.',
         'job_country.required' => 'The country  field is required.',
         'posting_summary.required' => 'The job posting summary  field is required.',
         'job_description.required' => 'The details of the job field is required.',
         'pin_code.required' => 'The zip Code field is required.',
         'job_image.required' => 'The job Image field is required.',
         'positions.required' => 'The positions field is required.',
         'segment.required' => 'The segment field is required.',
         'job_title.required' => 'The job title field is required.',
         'conditions.required' => 'The conditions field is required.',
         'requirements.required' => 'The requirements field is required.',
         'job_image.max' => 'The job Image should be less than 20MB.',
         'job_start_date.required' => 'The job start date field is required.',
         'recommended_skills.required' => 'Please select atleast one recommended skill.'

     ];
     if (isset($request->min_pay_range)  || isset($request->max_pay_range) || isset($request->currency_id)) {
      $rules['min_pay_range'] =  'required|numeric|gt:0';
      $rules['max_pay_range'] =     'required|numeric|gt:' . $request->min_pay_range;
          $rules['currency_id']  = 'required';
      ;
      $messages = [
          'min_pay_range.required' => 'The minimum salary field is required.',
          'min_pay_range.numeric' => 'The minimum salary must be number.',
          'max_pay_range.numeric' => 'The maximum salary must be number.',
          'min_pay_range.gt' => 'The minimum salary must be greater than 0.',
          'max_pay_range.required' => 'The maximum salary field is required.',
          'max_pay_range.gt' => 'The maximum salary must be greater than the minimum salary.',
          'currency_id.required' => 'The currency field is required.',
      ];
   }
      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
         return back()->withErrors($validator->errors())->withInput();
      }
      //   dd($request->all());
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
            $industries[] = (int)$industry['id'];
         }
         //   dd($request->all());
         $skills = json_encode($skills);
         $languages = json_encode($languages);
         $industries = json_encode($industries);
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
            $imageName = insertData($image,'jobs/');
            $job->job_image = '/storage/' . $imageName;
         }
         if($request->employer){
            $job->user_id = $request->employer;
         }else{
            $job->user_id = auth()->user()->id;
         }
         $job->update();
      } catch (\Exception $e) {
         return back()->withErrors(['success' => false, 'message' => $e->getMessage()]);
      }
      return to_route('jobs.index');
   }
   public function destroy($id)
   {
      $job = Jobs::findOrFail($id);
      JobStatus::where('job_id', $id)->each(function ($jobStatus) {
         $jobStatus->customers()->each(function ($customer) {
             $customer->travel_details()->forceDelete();            
             $customer->documents()->forceDelete();
             $customer->employments()->forceDelete();
             $customer->forceDelete();
         });
         $jobStatus->forceDelete();
     });
      $job->forceDelete();
      return to_route('jobs.index');
   }
   public function show($id)
   {

      $languages = Language::select('id', 'language_name as name')->get();
      $skills = Skills::all();
      $industries = Industries::withname();
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby')->where('id', $id)->first();


      return Inertia::render('Admin/Jobs/Show', compact('jobs','industries','skills','languages'));
   }

   public function job_listing(Request $request)
   {
      
      $user = Auth::user();
      $industry = '';
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills');
      
      // if($user && $user->user_type < 3){
      //    $jobs = $jobs->where('user_id' ,'!=',$user->id);
      // }
      if($request->industry){
         $industry = $request->industry;
         $jobs = $jobs->whereJsonContains('industry_id', (int)$request->industry);
        
         $industry  = Industries::where('id',$request->industry)->pluck('category_heading')->first();
      }
      if($request->country){
         $jobs = $jobs->where('job_country' ,$request->country);
         $industry = $request->country;
      }
      // $jobs = $jobs->get();
      // dd($jobs);
      $jobs = $jobs->paginate(9);
      $applied_jobs = Customer::where(['user_id'=>$user?->id,'submitted'=>1])->with('status')->pluck('job_id')->toArray();
      // dd($applied_jobs);
      return Inertia::render('Frontend/JobSection/JobListing', compact('jobs','user','applied_jobs','industry'));
   }

   public function view_job($id)
   {
      $job = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'business')->where('id', $id)->first();
      $checkexists = checkexists($job);
        if($checkexists == false){
            return redirect()->route('403');
        }
        $user = Auth::user();
      $languages = Language::select('id', 'language_name as name')->get();
      $skills = Skills::all();
      $created_time = $this->date_Time($job->created_at);
      $industries = Industries::withname();
      $applied_jobs = Customer::where('user_id',$user?->id)->with('status')->pluck('job_id')->toArray();
      $user = Auth::user();
      return Inertia::render('Frontend/JobSection/ViewJobs', compact('job','user','industries', 'languages', 'skills', 'created_time','applied_jobs'));
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
      // $applied_customers = Customer::where('customers_personal_details.job_id', $job_id)->join('jobs_with_customer_status', 'jobs_with_customer_status.customer_id', 'customers_personal_details.id')->select('customers_personal_details.*','jobs_with_customer_status.status as status')->with('status','statuz')->get();
      $applied_customers =  JobStatus::where('job_id',$job_id)->whereHas('customers',function($query){$query->where('submitted',1);})->with('customers','jobs','customers.travel_details')->latest()->get();
      $active = JobStatus::where('job_id', $job_id)->where('status', 0)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      $awaited = JobStatus::where('job_id', $job_id)->where('status', 1)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      $reviewed = JobStatus::where('job_id', $job_id)->where('status', 2)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      $contacted = JobStatus::where('job_id', $job_id)->where('status', 3)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      $hired = JobStatus::where('job_id', $job_id)->where('status', 4)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      $rejected = JobStatus::where('job_id', $job_id)->where('status', 5)->whereHas('customers',function($query){$query->where('submitted',1);})->count();
      // dd($applied_customers);
      $status = [
         'all' => count($applied_customers),
         'active' => $active,
         'awaited' => $awaited,
         'reviewed' => $reviewed,
         'contacted' => $contacted,
         'hired' => $hired,
         'rejected' => $rejected,
      ];
      // dd($status);
      return Inertia::render('Admin/Jobs/ViewCustomers', compact('applied_customers', 'job_id', 'status'));
   }
   public function data_filteration($job_id, $status)
   {
      $applied_customers = JobStatus::where('status',$status)->where('job_id',$job_id)->whereHas('customers',function($query){$query->where('submitted',1);})->with('customers','jobs','customers.travel_details')->get();
      return response()->json(['applied_customers' => $applied_customers]);
   }
   public function view_applied_customer($customer_id,$job_id = null){
      $customer = Customer::where('id',$customer_id)->with('travel_details','documents','employments')->first();
      return Inertia::render('Admin/Jobs/ViewAppliedCustomer',compact('customer','job_id'));
   }
}