<?php

namespace App\Http\Controllers;

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
    public function submit_personal_details(Request $request)
    {
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
            "visa_available" => 'required',
        ]);
        // if ($validator->fails()) {
        //     dd($request->all());
        //     return back()->withErrors($validator->errors());
        // }
        // dd($request->all());
        // dd($customer_personal_detail,$request->all());
        $password = Str::random(6);
        $create_customer = User::create([
            'name' => $request->first_name.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($password),
            // 'phone' => $request->mobile_number,
            'user_type' => "3",
            'status' => 1,
        ]);
        $customer_personal_detail = $request->except('date_of_travel','customer_image','passenger_nationality','purpose_of_stay','type_of_visa','port_of_arrival');
        $customer_personal_details = new Customer();
        $customer_personal_details->fill($customer_personal_detail);
        if(isset($request->customer_image)&& $request->file('customer_image')){
            $image = $request->file('customer_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('customer/personal/'.$name, file_get_contents($image));
            $customer_personal_details->customer_image = '/storage/customer/personal/' .$name;
        }
        $customer_personal_details->save();
        // dd($customer_personal_details);
        $customer_travel_detail = $request->only('date_of_travel','passenger_nationality','purpose_of_stay','type_of_visa','port_of_arrival','job_id');
        // dd($customer_travel_detail);
        $customer_travel_details = new CustomerTravelDetails();
        $customer_travel_details->fill($customer_travel_detail);
        $customer_travel_details->customer_id = $customer_personal_details->id;
        $customer_travel_details->updated_at =null;
        $customer_travel_details->save();
        Mail::to($create_customer->email)->send(new RegisteredCustomer($create_customer->name, $create_customer->email, $password, $create_customer->name));
        Auth::login($create_customer);
        Mail::to($create_customer->email)->send(new VerifyUser($create_customer->id,$create_customer->name, $create_customer->email, $password, $create_customer->name));
        dd("here");

        
        
    }


}
