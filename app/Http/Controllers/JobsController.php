<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Inertia\Inertia;
use App\Models\Skills;
use App\Models\Customer;
use App\Models\Position;
use App\Models\Discipline;
use App\Models\Industries;
use App\Models\VideoIntro;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\Workexperience;
use App\Models\CustomerTraining;
use App\Models\CustomerDocuments;
use Illuminate\Contracts\Queue\Job;
use App\Models\CustomerTravelDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
   public function index(){
        $jobs = Jobs::with('position','work_experience','discipline','industry','seniority','skills')->get();
        return Inertia::render('Admin/Jobs/Index',compact('jobs'));
   }
   public function create(){
      $positions= Position::all();
      $skills= Skills::all();
      $industries=Industries::all();
      $disciplines= Discipline::all();
      $seniorities= Seniorities::all();
      $work_experience= Workexperience::all();
    return Inertia::render('Admin/Jobs/Create',compact('positions','skills','industries','disciplines','seniorities','work_experience'));
   }
   public function store(Request $request){
      // dd($request->all());
  
      $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "job_image" => 'required',
            "job_description" => 'required',
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
            "min_pay_range" => 'required',
            "max_pay_range" => 'required',
            "job_start_date" => 'required',
         ],[
            'min_pay_range.required'=>'The minimum salary  field is required.' ,
            'max_pay_range.required'=>'The maximum salary  field is required.' 
         ]);
      if($validate->fails()){
         return back()->withErrors($validate->errors())->withInput();
      }
      $skills = [];
      foreach($request->skills_id as $skill){
         $skills[] = $skill['id'];
      }
      $skills = json_encode($skills);
      $job = new Jobs();
      $job->fill($request->except('skills_id'));
      $job->skills_id =$skills;
      if ($request->hasFile('job_image')) {
         $image = $request->file('job_image');
         $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
         Storage::disk('public')->put('jobs/'.$name, file_get_contents($image));
         $job->job_image ='/storage/jobs/'. $name;
     }
      $job->user_id = auth()->user()->id; 
      $job->save();
      return to_route('jobs.index');
   }
   public function edit($id){
      $positions= Position::all();
      $skills= Skills::all();
      $industries=Industries::all();
      $disciplines= Discipline::all();
      $seniorities= Seniorities::all();
      $work_experience= Workexperience::all();
      $job = Jobs::where('id',$id)->first();
      // $job->skills_id = json_decode($job->skills_id);
      // dd($job);
      return Inertia::render('Admin/Jobs/Edit',compact('positions','skills','industries','disciplines','seniorities','work_experience','job'));
   }
   public function update($id,Request $request){
         $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "job_image" => 'required',
            "job_description" => 'required',
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
            "min_pay_range" => 'required',
            "max_pay_range" => 'required',
            "job_start_date" => 'required',
         ],[
            'min_pay_range.required'=>'The minimum salary  field is required.' ,
            'max_pay_range.required'=>'The maximum salary  field is required.' 
         ]);
            if($validate->fails()){
               return back()->withErrors($validate->errors())->withInput();
            }
            
      $skills = [];
      foreach($request->skills_id as $skill){
         $skills[] = $skill['id'];
      }
      $skills = json_encode($skills);
      $job = Jobs::findOrFail($id);
      $job->fill($request->except('skills_id'));
      $job->skills_id =$skills;
      if ($request->hasFile('job_image')) {
         $image = $request->file('job_image');
         $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
         Storage::disk('public')->put('jobs/'.$name, file_get_contents($image));
         $job->job_image ='/storage/jobs/'. $name;
      }
      $job->user_id = auth()->user()->id; 
      $job->save();
      return to_route('jobs.index');
   }
   public function destroy($id){
      $job = Jobs::findOrFail($id);
      $job->forceDelete();
      return to_route('jobs.index');
   }
   public function show($id){
      $jobs = Jobs::with('position','work_experience','discipline','industry','seniority','skills','createdby')->where('id',$id)->first();

      $applied_customers = Customer::where('job_id',$id)->get();
      
      return Inertia::render('Admin/Jobs/Show',compact('jobs','applied_customers'));
   }

   public function job_listing(){
      $jobs = Jobs::with('position','work_experience','discipline','industry','seniority','skills')->get();
      return Inertia::render('Frontend/JobSection/JobListing',compact('jobs'));
   }

   public function view_job($id){
      $job = Jobs::with('position','work_experience','discipline','industry','seniority','skills')->where('id',$id)->first();
      return Inertia::render('Frontend/JobSection/ViewJobs',compact('job'));
   }
}
