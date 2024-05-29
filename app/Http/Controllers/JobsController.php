<?php

namespace App\Http\Controllers;

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
use App\Models\Industries;
use App\Models\VideoIntro;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\CustomerStatus;
use App\Models\Workexperience;
use App\Models\CustomerTraining;
use App\Models\CustomerDocuments;
use Illuminate\Contracts\Queue\Job;
use App\Models\CustomerTravelDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
   public function index()
   {
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby')->get();
      return Inertia::render('Admin/Jobs/Index', compact('jobs'));
   }
   public function create()
   {
      $positions = Position::all();
      $skills = Skills::all();
      $industries = Industries::all();
      $disciplines = Discipline::all();
      $seniorities = Seniorities::all();
      $work_experience = Workexperience::all();
      $currencies = Currency::all();
      $languages = Language::select('id', 'language_name as name')->get();
      return Inertia::render('Admin/Jobs/Create', compact('languages', 'currencies', 'positions', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience'));
   }
   public function store(Request $request)
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
         'positions.required' => 'Positions  is required.',
         'segment.required' => 'Segment  is required.',
         'job_title.required' => 'Job title  is required.',
         'conditions.required' => 'Conditions  is required.',
         'requirements.required' => 'Requirements  is required.',
         'job_image.max' => 'Job Image should be less than 20MB.',
         'job_start_date.required' => 'Job start date  is required.'

     ];
      if (isset($request->min_pay_range)) {
         $rules["min_pay_range"] = 'required|gt:0';
         $rules["max_pay_range"] = "required|gt:$request->min_pay_range";
         $rules["currency_id"] = 'required';
         $message['min_pay_range.required'] = 'Minimum salary  is required.';
         $message['min_pay_range.gt'] = 'Minimum salary must be greater than 0.';
         $message['currency_id.required'] = 'Currency  is required.';
         $message['max_pay_range.gt'] = 'Minimum salary  must be greater than 0.';
         $message['max_pay_range.required'] = 'Maximum salary  is required.';
      }
      $validate = Validator::make($request->all(), $rules, $messages);
      if ($validate->fails()) {
         return back()->withErrors($validate->errors())->withInput();
      }

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
         //   dd($industries);
         $skills = json_encode($skills);
         $languages = json_encode($languages);
         $industries = json_encode($industries);
         $job = new Jobs();
         $job->fill($request->except('skills_id'));
         $job->skills_id = $skills;
         $job->language_id = $languages;
         $job->industry_id = $industries;
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
      return to_route('jobs.index');
   }
   public function edit($id)
   {
      $positions = Position::all();
      $skills = Skills::all();
      $industries = Industries::all();
      $disciplines = Discipline::all();
      $seniorities = Seniorities::all();
      $work_experience = Workexperience::all();
      $job = Jobs::where('id', $id)->first();
      $currencies = Currency::all();
      $languages = Language::select('id', 'language_name as name')->get();
      return Inertia::render('Admin/Jobs/Edit', compact('positions', 'currencies', 'languages', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience', 'job'));
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
         'job_start_date.required' => 'Job start date  is required.'

     ];
      if (isset($request->min_pay_range)) {
         $rules["min_pay_range"] = 'required|gt:0';
         $rules["max_pay_range"] = "required|gt:$request->min_pay_range";
         $rules["currency_id"] = 'required';
         $message['min_pay_range.required'] = 'Minimum salary  is required.';
         $message['min_pay_range.gt'] = 'Minimum salary must be greater than 0.';
         $message['currency_id.required'] = 'Currency  is required.';
         $message['max_pay_range.gt'] = 'Minimum salary  must be greater than 0.';
         $message['max_pay_range.required'] = 'Maximum salary  is required.';
      }
      $validate = Validator::make($request->all(), $rules, $messages);
      if ($validate->fails()) {
         return back()->withErrors($validate->errors())->withInput();
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
            $industries[] = $industry['id'];
         }
         //   dd($industries);
         $skills = json_encode($skills);
         $languages = json_encode($languages);
         $industries = json_encode($industries);
         $job = Jobs::findOrFail($id);
         $job->fill($request->except('skills_id'));
         $job->skills_id = $skills;
         $job->language_id = $languages;
         $job->industry_id = $industries;
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
      return to_route('jobs.index');
   }
   public function destroy($id)
   {
      $job = Jobs::findOrFail($id);
      $job->forceDelete();
      return to_route('jobs.index');
   }
   public function show($id)
   {

      $languages = Language::select('id', 'language_name as name')->get();
      $skills = Skills::all();
      $industries = Industries::all();
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby')->where('id', $id)->first();


      return Inertia::render('Admin/Jobs/Show', compact('jobs','industries','skills','languages'));
   }

   public function job_listing()
   {
      $jobs = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills')->get();
      return Inertia::render('Frontend/JobSection/JobListing', compact('jobs'));
   }

   public function view_job($id)
   {
      $job = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'business')->where('id', $id)->first();
      $languages = Language::select('id', 'language_name as name')->get();
      $skills = Skills::all();
      $created_time = $this->date_Time($job->created_at);
      $industries = Industries::all();
      return Inertia::render('Frontend/JobSection/ViewJobs', compact('job','industries', 'languages', 'skills', 'created_time'));
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
      $applied_customers = Customer::where('job_id', $job_id)->with('status')->get();
      // dd($applied_customers->status);
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
      return Inertia::render('Admin/Jobs/ViewCustomers', compact('applied_customers', 'job_id', 'status'));
   }
   public function data_filteration($job_id, $status)
   {
      $applied_customers = Customer::where('customers_personal_details.job_id', $job_id)->leftJoin('jobs_with_customer_status', 'jobs_with_customer_status.customer_id', 'customers_personal_details.id')->where('jobs_with_customer_status.status', $status)->with('status')->get();
      return response()->json(['applied_customers' => $applied_customers]);
   }
}
