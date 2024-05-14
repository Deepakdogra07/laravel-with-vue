<?php

namespace App\Http\Controllers;

use App\Models\CustomerTraining;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\VerifyUser;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisteredCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\CustomerTravelDetails;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    public function introduction(Request $request)
    {
        $job_id = $request->job_id;
        return Inertia::render('Frontend/CustomerSection/Introduction/Index', compact('job_id'));
    }
    public function travel_details($job_id)
    {
        return Inertia::render('Frontend/CustomerSection/Travel/TravelDetail', compact('job_id'));
    }
    public function personal_details(Request $request,$job_id)
    {
        if ($request->isMethod('get')) {
            return to_route('travel.details', $job_id);
        }
        $validator = Validator::make($request->all(), [
            "purpose_of_stay" => 'required',
            "type_of_visa" => 'required',
            "date_of_travel" => 'required',
            "passenger_nationality" => 'required',
            "port_of_arrival" => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $variable = ($request->all());
        return Inertia::render('Frontend/CustomerSection/Travel/PersonalDetail', compact('variable'));
    }
    public function submit_personal_details(Request $request,$job_id)
    {
        if ($request->isMethod('get')) {
            return to_route('travel.details', $job_id);
        }
        $validator = Validator::make($request->all(), [
            "purpose_of_stay" => 'required',
            "type_of_visa" => 'required',
            "date_of_travel" => 'required',
            "passenger_nationality" => 'required',
            "port_of_arrival" => 'required',
            "customer_image" => 'required',
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "confirm_email" => 'required',
            "date_of_birth" => 'required',
            "country_of_birth" => 'required',
            "city_of_birth" => 'required',
            "gender" => 'required',
            "martial_status" => 'required',
            "passport_number" => 'required',
            "issuing_authority" => 'required',
            "passport_date_of_expiry" => 'required',
            // "citizen_of_more_than_one" => 'required',
            // "visa_available" => 'required',
        ]);
        if ($validator->fails()) {
            $variable = $request->all();
            $errors = $validator->errors();
            return Inertia::render('Frontend/CustomerSection/Travel/PersonalDetail',compact('errors','variable'));
        }
        
        
        $customer_personal_detail = $request->except('date_of_travel','customer_image','passenger_nationality','purpose_of_stay','type_of_visa','port_of_arrival');
        $customer_personal_details = new Customer();
        $customer_personal_details->fill($customer_personal_detail);
        if(isset($request->customer_image)&& $request->file('customer_image')){
            $image = $request->file('customer_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/personal/'.$name, file_get_contents($image));
            $customer_personal_details->customer_image = '/storage/customer/personal/' .$name;
        }
        $customer_personal_details->visa_available = isset($request->visa_available)? 1:0;
        $customer_personal_details->save();
        // dd($customer_personal_details);
        $customer_travel_detail = $request->only('date_of_travel','passenger_nationality','purpose_of_stay','type_of_visa','port_of_arrival','job_id');
        // dd($customer_travel_detail);
        $customer_travel_details = new CustomerTravelDetails();
        $customer_travel_details->fill($customer_travel_detail);
        $customer_travel_details->customer_id = $customer_personal_details->id;
        $customer_travel_details->updated_at =null;
        $customer_travel_details->save();
        $password = Str::random(6);
        $already_customer = User::where('email',$request->email)->first();
        if(!$already_customer){
            $create_customer = User::create([
                'name' => $request->first_name.$request->last_name,
                'email' => $request->email,
                'password' => Hash::make($password),
                // 'phone' => $request->mobile_number,
                'user_type' => "3",
                'status' => 1,
            ]);
            Mail::to($create_customer->email)->send(new RegisteredCustomer($create_customer->name, $create_customer->email, $password, $create_customer->name));
            Mail::to($create_customer->email)->send(new VerifyUser($create_customer->id , $create_customer->name, $create_customer->email, $password, $create_customer->name));
        }else{
            $create_customer  = $already_customer;
        }
        
        return redirect()->route('employment.details',[$request->job_id,$create_customer->id]);

        
        
    }
    public function employment_details($job_id,$customer_id){
        
        return Inertia::render('Frontend/CustomerSection/Employment/Index',compact('job_id','customer_id'));
    }
    public function submit_employment_details(Request $request){
       
        $validator = Validator::make($request->all(), [
            "employer_statement" => 'required',
            "financial_evidence" => 'required',
            "evidence_self_employment" => 'required',
            "formal_training_evidence" => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $customer_employments = new CustomerTraining();
        $customer_employments->fill($request->all());
        if(isset($request->employer_statement)&& $request->file('employer_statement')){
            $image = $request->file('employer_statement');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/employments/'.$name, file_get_contents($image));
            $customer_employments->employer_statement = '/storage/customer/employments/' .$name;
        }
        if(isset($request->financial_evidence)&& $request->file('financial_evidence')){
            $image = $request->file('financial_evidence');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/employments/'.$name, file_get_contents($image));
            $customer_employments->financial_evidence = '/storage/customer/employments/' .$name;
        }
        if(isset($request->evidence_self_employment)&& $request->file('evidence_self_employment')){
            $image = $request->file('evidence_self_employment');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/employments/'.$name, file_get_contents($image));
            $customer_employments->evidence_self_employment = '/storage/customer/employments/' .$name;
        }
        if(isset($request->formal_training_evidence)&& $request->file('formal_training_evidence')){
            $image = $request->file('formal_training_evidence');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/employments/'.$name, file_get_contents($image));
            $customer_employments->formal_training_evidence = '/storage/customer/employments/' .$name;
        }
        $customer_employments->updated_at = null;
        $customer_employments->save();
        $job_id = $request->job_id;
        $customer_id = $request->customer_id;
        return to_route(route('document.details',$job_id,$customer_id));
        // return Inertia::render('Frontend/CustomerSection/Employment/Index',compact('job_id','customer_id'));
    }
    public function document_details($job_id , $customer_id){
        return Inertia::render('Frontend/CustomerSection/Documents/Index',compact('job_id','customer_id'));
    }
}
