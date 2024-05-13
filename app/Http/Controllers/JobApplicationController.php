<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

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
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        dd($request->all());
    }


}
