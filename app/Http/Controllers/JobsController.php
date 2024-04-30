<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\JobsWithCustomers;
use App\Models\Customer;
use App\Models\CustomerDocuments;
use App\Models\CustomerPassports;
use App\Models\CustomerTraining;
use App\Models\VideoIntro;
use App\Models\Position;
use App\Models\Skills;
use App\Models\Industries;
use App\Models\Discipline;
use App\Models\Seniorities;
use App\Models\Workexperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

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
      $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "position_type" => 'required',
            "seniority" => 'required',
            "discipline" => 'required',
            "work_experience" => 'required',
            "skills" => 'required',
            "industry" => 'required',
            "positions" => 'required',
            "pin_code" => 'required',
            // "city" => 'required',
            "state" => 'required',
            "pay_range" => 'required',
            "job_start_date" => 'required',
            // "application_link" => 'required',
         ]);
      if($validate->fails()){
         return back()->withErrors($validate->errors())->withInput();
      }
      $skills = json_encode($request->skills);
      $job = new Jobs();
      $job->fill($request->all());
      $job->skills =$skills;
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
      $job->skills = json_decode($job->skills);
      return Inertia::render('Admin/Jobs/Edit',compact('positions','skills','industries','disciplines','seniorities','work_experience','job'));
   }
   public function update($id,Request $request){
    $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "position_type" => 'required',
            "seniority" => 'required',
            "discipline" => 'required',
            "work_experience" => 'required',
            "skills" => 'required',
            "industry" => 'required',
            "positions" => 'required',
            "pin_code" => 'required',
            // "city" => 'required',
            "state" => 'required',
            "pay_range" => 'required',
            "job_start_date" => 'required',
            // "application_link" => 'required',
         ]);
      if($validate->fails()){
         return back()->withErrors($validate->errors())->withInput();
      }
      $skills = json_encode($request->skills);
      $job = Jobs::findOrFail($id);
      $job->fill($request->all());
      $job->skills =$skills;
      $job->user_id = auth()->user()->id; 
      $job->update();
      return to_route('jobs.index');
   }
   public function destroy($id){
      $job = Jobs::findOrFail($id);
      $job->forceDelete();
      return to_route('jobs.index');
   }
   public function show($id){
      $jobs = Jobs::with('position','work_experience','discipline','industry','seniority','skills','createdby')->where('id',$id)->first();

      $applied_customers = JobsWithCustomers::where('job_id',$id)->with('customers')->get();
      
      return Inertia::render('Admin/Jobs/Show',compact('jobs','applied_customers'));
   }
}
