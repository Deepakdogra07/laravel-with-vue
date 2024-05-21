<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Jobs;
use Inertia\Inertia;
use App\Models\Skills;
use App\Models\Customer;
use App\Models\Language;
use App\Models\Position;
use App\Models\Discipline;
use App\Models\FooterData;
use App\Models\Industries;
use App\Rules\MaxWords;
use App\Models\Seniorities;
use Illuminate\Http\Request;
use App\Models\CustomerStatus;
use App\Models\Workexperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $jobs = Jobs::where('user_id', Auth::user()->id)->with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills')->get();   //Get data for particular business
        $footer_data = FooterData::first();
        return Inertia::render('Business/Index', compact('jobs', 'footer_data'));

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
        return Inertia::render('Business/Create', compact('languages', 'positions', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "job_image" => 'required',
            "job_description" => 'required',
            "posting_summary" =>  ['required', new MaxWords(30)],
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
            "min_pay_range" => 'required',
            "max_pay_range" => 'required',
            "job_start_date" => 'required',
        ], [
            'min_pay_range.required' => 'The minimum salary  field is required.',
            'max_pay_range.required' => 'The maximum salary  field is required.',
            'position_id.required' => 'The position type field is required.',
            'seniority_id.required' => 'The seniority field is required.',
            'discipline_id.required' => 'The discipline field is required.',
            'work_experience_id.required' => 'The overall work experience field is required.',
            'skills_id.required' => 'The skills field is required.',
            'language_id.required' => 'The language field is required.',
            'industry_id.required' => 'The industry field is required.',
            'job_country.required' => 'The country field is required.',
            'posting_summary.required' => 'The job posting summary field is required.',
            'job_description.required' => 'The details of the job field is required.'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        $skills = [];
        $languages = [];
        foreach ($request->skills_id as $skill) {
            $skills[] = $skill['id'];
        }
        foreach ($request->language_id as $language) {
            $languages[] = $language['id'];
        }
        $skills = json_encode($skills);
        $languages = json_encode($languages);
        $job = new Jobs();
        $job->fill($request->except('skills_id'));
        $job->skills_id = $skills;
        $job->language_id = $languages;
        if ($request->hasFile('job_image')) {
            $image = $request->file('job_image');
            $name = uniqid() . '_' . time() . '_' . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put('jobs/' . $name, file_get_contents($image));
            $job->job_image = '/storage/jobs/' . $name;
        }
        $job->user_id = auth()->user()->id;
        $job->save();
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
        $job = Jobs::where('id', $id)->first();
        // $job->skills_id = json_decode($job->skills_id);
        // dd($job);
        $languages = Language::select('id', 'language_name as name')->get();
        return Inertia::render('Business/Edit', compact('positions', 'languages', 'skills', 'industries', 'disciplines', 'seniorities', 'work_experience', 'job'));
    }
    public function update($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            "job_title" => 'required',
            "job_image" => 'required',
            "job_description" => 'required',
            "posting_summary" =>  ['required', new MaxWords(30)],
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
            "min_pay_range" => 'required',
            "max_pay_range" => 'required',
            "job_start_date" => 'required',
        ], [
            'min_pay_range.required' => 'The minimum salary  is required.',
            'max_pay_range.required' => 'The maximum salary  is required.',
            'position_id.required' => 'The position type is required.',
            'seniority_id.required' => 'The seniority is required.',
            'discipline_id.required' => 'The discipline is required.',
            'work_experience_id.required' => 'The overall work experience is required.',
            'skills_id.required' => 'The skills is required.',
            'language_id.required' => 'The language is required.',
            'industry_id.required' => 'The industry is required.',
            'job_country.required' => 'The country is required.',
            'posting_summary.required' => 'The job posting summary  is required.',
            'job_description.required' => 'The details of the job  is required.'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }

        $skills = [];
        $languages = [];
        foreach ($request->skills_id as $skill) {
            $skills[] = $skill['id'];
        }
        foreach ($request->language_id as $language) {
            $languages[] = $language['id'];
        }
        $skills = json_encode($skills);
        $languages = json_encode($languages);
        $job = Jobs::findOrFail($id);
        $job->fill($request->except('skills_id'));
        $job->skills_id = $skills;
        $job->language_id = $languages;
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
        return to_route('business-jobs.index');
    }
    public function show($id)
    {
        $job = Jobs::with('position', 'work_experience', 'discipline', 'industry', 'seniority', 'skills', 'createdby', 'business')->where('id', $id)->first();
        $created_time = $this->date_Time($job->created_at);
        $applied_customers = Customer::where('job_id', $id)->get();
        $languages= Language::select('id','language_name as name')->get();
        $skills= Skills::all();
        $created_time = $this->date_Time($job->created_at);

        return Inertia::render('Business/Show', compact('job','languages','skills', 'applied_customers', 'created_time'));
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
        $applied_customers = Customer::where('job_id', $job_id)->with('status')->get();
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
    public function data_filteration($job_id, $status)
    {
        $applied_customers = Customer::where('customers_personal_details.job_id', $job_id)->leftJoin('jobs_with_customer_status', 'jobs_with_customer_status.customer_id', 'customers_personal_details.id')->where('jobs_with_customer_status.status', $status)->with('status')->get();
        return response()->json(['applied_customers' => $applied_customers]);
    }
}
