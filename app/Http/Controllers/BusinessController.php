<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Inertia\Inertia;
use App\Models\Skills;
use App\Models\Customer;
use App\Models\Position;
use App\Models\Discipline;
use App\Models\FooterData;
use App\Models\Industries;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\Workexperience;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
   public function index(){
    $jobs = Jobs::where('user_id',Auth::user()->id)->with('position','work_experience','discipline','industry','seniority','skills')->get();   //Get data for particular business
    $footer_data = FooterData::first();
    return Inertia::render('Business/Index',compact('jobs','footer_data'));

   }
   public function create(){
    $positions= Position::all();
    $skills= Skills::all();
    $industries=Industries::all();
    $disciplines= Discipline::all();
    $seniorities= Seniorities::all();
    $work_experience= Workexperience::all();
    return Inertia::render('Business/Create',compact('positions','skills','industries','disciplines','seniorities','work_experience'));
   }

   public function store(Request $request){
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
          "pin_code" => 'required|max:6|min:6',
          "city" => 'required',
          "segment" => 'required',
          "job_country" => 'required',
          "min_pay_range" => 'required',
          "max_pay_range" => 'required',
          "job_start_date" => 'required',
       ],[
          'min_pay_range.required'=>'The minimum salary  field is required.' ,
          'max_pay_range.required'=>'The maximum salary  field is required.' ,
          'position_id.required'=>'The position type field is required.' ,
          'seniority_id.required'=>'The seniority field is required.' ,
          'discipline_id.required'=>'The discipline field is required.' ,
          'work_experience_id.required'=>'The overall work experience field is required.' ,
          'skills_id.required'=>'The skills field is required.' ,
          'industry_id.required'=>'The industry field is required.' ,
          'job_country.required'=>'The country field is required.' ,
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
    return to_route('business-jobs.index');
 }
    public function edit($id){
        $positions= Position::all();
        $skills= Skills::all();
        $industries=Industries::all();
        $disciplines= Discipline::all();
        $seniorities= Seniorities::all();
        $work_experience= Workexperience::all();
        $job = Jobs::where('id',$id)->first();
        return Inertia::render('Business/Edit',compact('positions','skills','industries','disciplines','seniorities','work_experience','job'));
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
        "pin_code" => 'required|max:6|min:6',
        "city" => 'required',
        "segment" => 'required',
        "job_country" => 'required',
        "min_pay_range" => 'required',
        "max_pay_range" => 'required',
        "job_start_date" => 'required',
        ],[
        'min_pay_range.required'=>'The minimum salary  field is required.' ,
        'max_pay_range.required'=>'The maximum salary  field is required.' ,
        'position_id.required'=>'The position type field is required.' ,
        'seniority_id.required'=>'The seniority field is required.' ,
        'discipline_id.required'=>'The discipline field is required.' ,
        'work_experience_id.required'=>'The overall work experience field is required.' ,
        'skills_id.required'=>'The skills field is required.' ,
        'industry_id.required'=>'The industry field is required.' ,
        'job_country.required'=>'The country field is required.' ,
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
    $job->fill($request->except('skills_id','job_image'));
    $job->skills_id =$skills;
    if ($request->hasFile('job_image')) {
        if (public_path($job->job_image)) {
        $imagePath = substr($job->job_image, strlen('/storage'));
        Storage::disk('public')->delete($imagePath);
        }
        $image = $request->file('job_image');
        $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
        Storage::disk('public')->put('jobs/'.$name, file_get_contents($image));
        $job->job_image ='/storage/jobs/'. $name;
    }
    $job->user_id = auth()->user()->id; 
    $job->update();
    return to_route('business-jobs.index');
    }
    public function show($id){
        $job = Jobs::with('position','work_experience','discipline','industry','seniority','skills','createdby','business')->where('id',$id)->first();
        $created_time = $this->date_Time($job->created_at);
        $applied_customers = Customer::where('job_id',$id)->get();
        
        return Inertia::render('Business/Show',compact('job','applied_customers','created_time'));
     }



    public function destroy($id){
        $job = Jobs::findOrFail($id);
        $job->forceDelete();
        return to_route('jobs.index');
    }
    private function date_Time($created_at){
        $current_datetime = new DateTime(); // Current date and time
        $job_created_at = new DateTime($created_at); // Job creation date and time

        // Calculate the difference
        $interval = $current_datetime->diff($job_created_at);
        $time= '';
        if ($interval->d > 0) {
            $time= $interval->d . ' days ago';
        } elseif ($interval->h > 0) {
            $time= $interval->h . ' hours ago';
        } elseif ($interval->i > 0) {
            $time= $interval->i . ' minutes ago';
        } else {
            $time= 'Just now';
        }
        return $time;
    }
}
