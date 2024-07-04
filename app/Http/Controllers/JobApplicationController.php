<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocuments;
use App\Models\CustomerStatus;
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
use App\Http\Controllers\PayPalController;


class JobApplicationController extends Controller
{
    public $paypal;

    public function __construct(){
        $this->paypal = new PayPalController();
    }
    public function introduction(Request $request)
    {
        $job_id = $request->job_id;
        $customer_id = $request->customer_id;
        // dd('here');
        return Inertia::render('Frontend/CustomerSection/Introduction/Index', compact('job_id','customer_id'));
    }
    public function travel_details($job_id)
    {
        $user_id = Auth::user()->id ?? '';
        $already_customer = Customer::where('user_id',$user_id)->with('travel_details')->first();
        return Inertia::render('Frontend/CustomerSection/Travel/TravelDetail', compact('job_id','already_customer'));
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
            "migrate_country" => 'required',
        ],[
            'migrate_country.required' =>'Country to immigrate  is required.',
            "purpose_of_stay.required" => 'Purpose of stay is required.',
            "type_of_visa.required" => 'Type of visa is required.',
            "date_of_travel.required" => 'Date of travel is required.',
            "passenger_nationality.required" => 'Passenger nationality is required.',
            "port_of_arrival.required" => 'Port of arrival is required.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        $variable = ($request->all());
        $user_id = Auth::user()->id ?? '';
        $user_email = Auth::user()->email ?? null;
        $already_customer = Customer::where('user_id',$user_id)->with('travel_details')->first();
        return Inertia::render('Frontend/CustomerSection/Travel/PersonalDetail', compact('variable','already_customer','user_email'));
    }
    public function submit_personal_details(Request $request,$job_id)
    {
        // dd($request->all());
        if ($request->isMethod('get')) {
            return to_route('travel.details', $job_id);
        }
        $user = Auth::user();
        $rule = [
            "purpose_of_stay" => 'required',
            "type_of_visa" => 'required',
            "date_of_travel" => 'required',
            "passenger_nationality" => 'required',
            "port_of_arrival" => 'required',
            "first_name" => 'required',
            "last_name" => 'required',
            "email" =>'required|email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,3}$/',
            "confirm_email" => 'required|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,3}$/|same:email',
            "date_of_birth" => 'required',
            "country_of_birth" => 'required',
            "city_of_birth" => 'required',
            "gender" => 'required',
            "martial_status" => 'required',
            "passport_number" => 'required',
            "issuing_authority" => 'required',
            "date_of_expiry" => 'required',
        ];
        if($request->file('customer_image')){
            $rule ["customer_image" ]= 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480';
            $messages[ "customer_image.required"] = "Passport image is required.";
            $messages["customer_image.max"] = "Passport image should not be more than 20MB.";
            $messages["customer_image.mimes"] = "Passport image should be in jpg,jpeg,png,pdf,docx format.";   
        }
        $messages = [
            "purpose_of_stay.required" => "Purpose of stay is required.",
            "type_of_visa.required" => "Type of visa is required.",
            "date_of_travel.required" => "Date of travel is required.",
            "passenger_nationality.required" => "Passenger nationality is required.",
            "port_of_arrival.required" => "Port of arrival is required.",
            "customer_image.required" => "Passport image is required.",
            "customer_image.max" => "Passport image should not be more than 20MB.",
            "customer_image.mimes" => "Passport image should be in jpg,jpeg,png,pdf,docx format.",
            "first_name.required" => "First name is required.",
            "last_name.required" => "Last name is required.",
            "email.required" =>"Email is required",
            "email.regex" => "Email is invalid.",
            "email.email" => "Email is invalid.",
            "confirm_email.required" => "Confirm email is required.",
            "confirm_email.regex" => "Confirm email is invalid.",
            "date_of_birth.required" => "Date of birth is required.",
            "country_of_birth.required" => "Country of birth is required.",
            "city_of_birth.required" => "City of birth is required.",
            "gender.required" => "Gender is required.",
            "martial_status.required" => "Martial status is required.",
            "passport_number.required" => "Passport is required.",
            "issuing_authority.required" => "Issuing authority is required.",
            "date_of_expiry.required" => "Date of expiry is required.",
        ];
        
        $validator = Validator::make($request->all(), $rule,$messages);
        if ($validator->fails()) {
            $variable = $request->all();
            $errors = $validator->errors();
            return Inertia::render('Frontend/CustomerSection/Travel/PersonalDetail',compact('errors','variable'));
        }
        $user = User::where('email',$request->email)->first();
        if(!$user){
            $user = Auth::user();
        }
        if($user){
            $create_customer = $user; 
        }else{
            
            $password = Str::random(6);
                $create_customer = User::create([
                    'name' => $request->email,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    // 'phone' => $request->mobile_number,
                    'user_type' => "3",
                    'status' => 1,
                ]);
                Mail::to($create_customer->email)->send(new RegisteredCustomer($create_customer->name, $create_customer->email, $password, $create_customer->name));
                Mail::to($create_customer->email)->send(new VerifyUser($create_customer->id , $create_customer->name, $create_customer->email, $password, $create_customer->name));
        }
        $customer_personal_detail = $request->except('date_of_travel','customer_image','passenger_nationality','purpose_of_stay','type_of_visa','port_of_arrival');
        if($user){
            $customer_personal_details = Customer::where(['user_id'=>$user->id, 'submitted'=>0,'job_id'=>$request->job_id])->first();
            if(!$customer_personal_details){
                $customer_personal_details = new Customer();
                $customer_travel_details = new CustomerTravelDetails();
                $status = new CustomerStatus();
            }else{
                $customer_travel_details = CustomerTravelDetails::where('customer_id',$customer_personal_details->id)->first();
                $status = CustomerStatus::where('customer_id',$customer_personal_details->id)->first();
            }
        }else{
            $customer_personal_details = new Customer();
            $customer_travel_details = new CustomerTravelDetails();
            $status = new CustomerStatus();
        }
         // Personal Details Code
        $customer_personal_details->fill($customer_personal_detail);
        if(isset($request->customer_image)&& $request->file('customer_image')){
            $image = $request->file('customer_image');
            $imageName = insertData($image,'customer/personal/');
            $customer_personal_details->customer_image = '/storage/' .$imageName;
        }
        $citizen = (isset($request->citizen_of_more_than_one)) ? 1 : 0;
        $customer_personal_details->citizen_of_more_than_one_country = $citizen;
        $customer_personal_details->user_id = $create_customer->id;
        $customer_personal_details->visa_available = isset($request->visa_available)? 1:0;
        $customer_personal_details->save();
        $customer_travel_detail = $request->only('date_of_travel','passenger_nationality','migrate_country','purpose_of_stay','type_of_visa','port_of_arrival','job_id');
        // Travel Details Code
        $customer_travel_details->fill($customer_travel_detail);
        $customer_travel_details->customer_id = $customer_personal_details->id;
        $customer_travel_details->purpose_of_stay = $customer_travel_detail['purpose_of_stay'];
        $customer_travel_details->updated_at =null;
        $customer_travel_details->save();
        // Status Code
        $status->job_id = $customer_personal_details->job_id;
        $status->customer_id = $customer_personal_details->id;
        $status->status = 0;
        $status->save();

        return redirect()->route('job.introduction',[$request->job_id,$customer_personal_details->id]);

        
        
    }
    public function employment_details($job_id,$customer_id = null){
            return Inertia::render('Frontend/CustomerSection/Employment/Index',compact('job_id','customer_id'));
    }
    public function validate_emp_details(Request $request){
        if(isset($request->step) && $request->step == 1){
            $validator = Validator::make($request->all(), [
                "employer_statement" => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
            ],[
                "employer_statement.required" => 'Employer statement is required.',
                "employer_statement.max" => 'Employer statement file should not exceed 20 MB.',
                "employer_statement.mimes" => 'Employer statement should be in jpg,jpeg,png,pdf,docx format.',
            ]);
           }elseif(isset($request->step) && $request->step == 2){
            $validator = Validator::make($request->all(), [
                "financial_evidence" => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
            ],[
                "financial_evidence.required" => 'Financial evidence is required.',
                "financial_evidence.mimes" => 'Financial evidence should be in jpg,jpeg,png,pdf,docx format.',
                "financial_evidence.max" => 'Financial evidence file should not exceed 20 MB.',
            ]);
           }elseif(isset($request->step) && $request->step == 3){
            $validator = Validator::make($request->all(), [
                "evidence_self_employment" => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
                "evidence_self_employment_aus" => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
            ],[
                "evidence_self_employment.required" => 'Self employment  evidence  is required.',
                "evidence_self_employment_aus.required" => 'Self employment in australia evidence is required.',
                "evidence_self_employment_aus.mimes" => 'Self employment in australia should be in jpg,jpeg,png,pdf,docx format.',
                "evidence_self_employment.max" => ' Self employment evidence file should not exceed 20 MB.',
                "evidence_self_employment.mimes" => ' Self employment evidence should be in jpg,jpeg,png,pdf,docx format.',
                "evidence_self_employment_aus.max" => 'Self employment in australia evidence file should not exceed 20 MB.',
            ]);
            }elseif(isset($request->step) && $request->step == 4){
            $validator = Validator::make($request->all(), [
                "formal_training_evidence" => 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
            ],[
                "formal_training_evidence.max" => 'Formal training evidence file should not exceed 20 MB.',
                "formal_training_evidence.required" => 'Formal training evidence is required.',
                "formal_training_evidence.mimes" => 'Formal training evidence should be in jpg,jpeg,png,pdf,docx format.',
            ]);
           }
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors(),'step'=>$request->step,'success'=>false]);
            }elseif(isset($request->step) && $request->step < 4){
                return response()->json(['success'=>true ,'step'=>$request->step+1]);
            }
    }

    public function submit_employment_details(Request $request){
        
        if(isset($request->step) && $request->step == 1){
            $validator = Validator::make($request->all(), [
                "employer_statement" => 'required|max:20480',
            ],[
                "employer_statement.required" => 'employer statement is required.',
                "employer_statement.max" => 'employer statement file should not exceed 20 MB.',
            ]);
           }elseif(isset($request->step) && $request->step == 2){
            $validator = Validator::make($request->all(), [
                "employer_statement" => 'required|max:20480',
                "financial_evidence" => 'required|max:20480',
            ],[
                "financial_evidence.required" => 'financial evidence is required.',
                "financial_evidence.max" => 'financial evidence file should not exceed 20 MB.',
            ]);
           }elseif(isset($request->step) && $request->step == 3){
            $validator = Validator::make($request->all(), [
                "employer_statement" => 'required|max:20480',
                "financial_evidence" => 'required|max:20480',
                "evidence_self_employment" => 'required|max:20480',
                "evidence_self_employment_aus" => 'required|max:20480',
            ],[
                "evidence_self_employment.required" => 'self employment  evidence  is required.',
                "evidence_self_employment_aus.required" => 'self employment in australia evidence is required.',
                "evidence_self_employment.max" => ' self employment evidence file should not exceed 20 MB.',
                "evidence_self_employment_aus.max" => 'self employment in australia evidence file should not exceed 20 MB.',
            ]);
            
           }elseif(isset($request->step) && $request->step == 4){
            $validator = Validator::make($request->all(), [
                "employer_statement" => 'required|max:20480',
                "financial_evidence" => 'required|max:20480',
                "evidence_self_employment" => 'required|max:20480',
                "evidence_self_employment_aus" => 'required|max:20480',
                "formal_training_evidence" => 'required|max:20480',
            ],[
                "formal_training_evidence.max" => 'formal_training_evidence file should not exceed 20 MB.',
                "formal_training_evidence.required" => 'formal training evidence is required.',
            ]);
           }
           
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            $customer_employments = CustomerTraining::where(['job_id'=>$request->job_id,'customer_id'=>$request->customer_id])->first();
            if(!$customer_employments){
                $customer_employments = new CustomerTraining();
            }
            $customer_employments->fill($request->all());
            if(isset($request->employer_statement)&& $request->file('employer_statement')){
                $image = $request->file('employer_statement');
                $imageName = insertData($image,'customer/employments/');
                $customer_employments->employer_statement = '/storage/' .$imageName;
            }
            if(isset($request->financial_evidence)&& $request->file('financial_evidence')){
                $image = $request->file('financial_evidence');
                $imageName = insertData($image,'customer/employments/');
                $customer_employments->financial_evidence = '/storage/' .$imageName;
            }
            if(isset($request->evidence_self_employment)&& $request->file('evidence_self_employment')){
                $image = $request->file('evidence_self_employment');
                $imageName = insertData($image,'customer/employments/');
                $customer_employments->evidence_self_employment = '/storage/' .$imageName;
            }
            if(isset($request->evidence_self_employment_aus)&& $request->file('evidence_self_employment_aus')){
                $image = $request->file('evidence_self_employment_aus');
                $imageName = insertData($image,'customer/employments/');
                $customer_employments->evidence_self_employment_aus = '/storage/' .$imageName;
            }
            if(isset($request->formal_training_evidence)&& $request->file('formal_training_evidence')){
                $image = $request->file('formal_training_evidence');
                $imageName = insertData($image,'customer/employments/');
                $customer_employments->formal_training_evidence = '/storage/' .$imageName;
            }
            $customer_employments->updated_at = null;
            $customer_employments->save();
            $job_id = $request->job_id;
            $customer_id = $customer_employments->customer_id;
        return redirect()->route('document.details',[$job_id,$customer_id]);
    }
    public function document_details($job_id , $customer_id){
        return Inertia::render('Frontend/CustomerSection/Documents/Index',compact('job_id','customer_id'));
    }

public function validate_customer_documents(Request $request){
    if(isset($request->step) && $request->step == 1){
        $validator = Validator::make($request->all(), [
            'employment_evidence'=> 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
        ],[
            'employment_evidence.required'=> 'Employment evidence is required.',
            'employment_evidence.mimes'=> 'Employment evidence should be in jpg,jpeg,png,pdf,docx format.',
            'employment_evidence.max'=> 'Employment evidence file should not exceed 20 MB.',
        ]);
    }elseif(isset($request->step) && $request->step == 2){
        $validator = Validator::make($request->all(), [
           'licences'=> 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
        ],[
            'licences.required'=> 'Licences is required.',
            'licences.mimes'=> 'Licences should be in jpg,jpeg,png,pdf,docx format.',
            'licences.max'=> 'Licences file should not exceed 20 MB.',
        ]);
    }elseif(isset($request->step) && $request->step == 3){
        $validator = Validator::make($request->all(), [
           'is_australia'=> 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
        ],[
            'is_australia.required'=> 'Photograph is required.',
            'is_australia.mimes'=> 'Photograph should be in jpg,jpeg,png,pdf,docx format.',
            'is_australia.max'=> 'Photograph file should not exceed 20 MB.',
        ]);
    }elseif(isset($request->step) && $request->step == 5){
        $validator = Validator::make($request->all(), [
            'kitchen_area'=> 'required|mimes:mp4,mov,ogg,qt|max:20480',
            'ingredients'=> 'required|mimes:mp4,mov,ogg,qt|max:20480',
            'cooking_tech'=> 'required|mimes:mp4,mov,ogg,qt|max:20480',
            'dish'=> 'required|mimes:mp4,mov,ogg,qt|max:20480',
            'clean_up'=> 'required|mimes:mp4,mov,ogg,qt|max:20480',
        ],[
            'kitchen_area.required'=> 'Kitchen area is required.',
            'ingredients.required'=> 'Ingredients is required.',
            'cooking_tech.required'=> 'Cooking tech is required.',
            'dish.required'=> 'Dish is required.',
            'clean_up.required'=> 'Clean up is required.',

            'kitchen_area.max'=> 'Kitchen area file should not exceed 20 MB.',
            'ingredients.max'=> 'Ingredients file should not exceed 20 MB.',
            'cooking_tech.max'=> 'Cooking tech file should not exceed 20 MB.',
            'dish.max'=> 'Dish file should not exceed 20 MB.',
            'clean_up.max'=> 'Clean up file should not exceed 20 MB.',

            'kitchen_area.mimes'=> 'Kitchen area should be in .mp4,.mov or .ogg format.',
            'ingredients.mimes'=> 'Ingredients should be in .mp4,.mov or .ogg format.',
            'cooking_tech.mimes'=> 'Cooking tech should be in .mp4,.mov or .ogg format.',
            'dish.mimes'=> 'Dish should be in .mp4,.mov or .ogg format.',
            'clean_up.mimes'=> 'Clean up should be in .mp4,.mov or .ogg format.',


        ]);
    }elseif(isset($request->step) && $request->step == 6){
        $validator = Validator::make($request->all(), [
            'evidence_image'=> 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
        ],[
            'evidence_image.required'=> 'Evidence image is required.',
            'evidence_image.mimes'=> 'Evidence image should be in jpg,jpeg,png,pdf,docx format.',
            'evidence_image.max'=> 'Evidence image file should not exceed 20 MB.',
        ]);
    }
    elseif(isset($request->step) && $request->step == 7){
        $validator = Validator::make($request->all(), [
           'resume'=> 'required|mimes:jpg,jpeg,png,pdf,docx|max:20480',
        ],[
            'resume.max'=> 'Resume file should not exceed 20 MB.',
            'resume.mimes'=> 'Resume file should be in jpg,jpeg,png,pdf,docx format',
            'resume.required'=> 'Resume is required.',
        ]);
    }
    if ($validator->fails()) {
        return response()->json(['error'=>$validator->errors(),'step'=>$request->step,'success'=>false]);
    }elseif(isset($request->step) && ($request->step < 7)){
        return response()->json(['success'=>true ,'step'=>$request->step+1]);
    }
}

    public function submit_customers_documents(Request $request){
        $validator = Validator::make($request->all(), [
            'employment_evidence'=> 'required|max:20480',
            'licences'=> 'required|max:20480',
            'kitchen_area'=> 'required|max:20480',
            'ingredients'=> 'required|max:20480',
            'cooking_tech'=> 'required|max:20480',
            'dish'=> 'required|max:20480',
            'clean_up'=> 'required|max:20480',
            'evidence_image'=> 'required|max:20480',
            'resume'=> 'required|max:20480',
            
        ],[
            'employment_evidence.required'=> 'Employment evidence is required.',
            'licences.required'=> 'Licences is required.',
            'kitchen_area.required'=> 'Kitchen area is required.',
            'ingredients.required'=> 'Ingredients is required.',
            'cooking_tech.required'=> 'Cooking tech is required.',
            'dish.required'=> 'Dish is required.',
            'clean_up.required'=> 'Clean up is required.',
            'evidence_image.required'=> 'Evidence image is required.',
            'resume.required'=> 'Resume is required.',
            'employment_evidence.max'=> 'Employment evidence file should not exceed 20 MB.',
            'licences.max'=> 'Licences file should not exceed 20 MB.',
            'kitchen_area.max'=> 'Kitchen area file should not exceed 20 MB.',
            'ingredients.max'=> 'Ingredients file should not exceed 20 MB.',
            'cooking_tech.max'=> 'Cooking tech file should not exceed 20 MB.',
            'dish.max'=> 'Dish file should not exceed 20 MB.',
            'clean_up.max'=> 'Clean up file should not exceed 20 MB.',
            'evidence_image.max'=> 'Evidence image file should not exceed 20 MB.',
            'resume.max'=> 'Resume file should not exceed 20 MB.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }
        // dd($request->all());
        $customer = new CustomerDocuments();
        $customer->job_id = $request->job_id;
        $customer->customer_id = $request->customer_id;
        if(isset($request->employment_evidence)&& $request->file('employment_evidence')){
            $image = $request->file('employment_evidence');
            $imageName = insertData($image,'customer/documents/');
            $customer->employment_evidence = '/storage/' .$imageName;
        }
        if(isset($request->licences)&& $request->file('licences')){
            $image = $request->file('licences');
            $imageName = insertData($image,'customer/documents/');
            $customer->licences = '/storage/' .$imageName;
        }
        if(isset($request->kitchen_area)&& $request->file('kitchen_area')){
            $image = $request->file('kitchen_area');
            $imageName = insertData($image,'customer/documents/');
            $customer->kitchen_area = '/storage/' .$imageName;
        }
        if(isset($request->cooking_tech)&& $request->file('cooking_tech')){
            $image = $request->file('cooking_tech');
            $imageName = insertData($image,'customer/documents/');
            $customer->cooking_tech = '/storage/' .$imageName;
        }
        if(isset($request->ingredients)&& $request->file('ingredients')){
            $image = $request->file('ingredients');
            $imageName = insertData($image,'customer/documents/');
            $customer->ingredients = '/storage/' .$imageName;
        }
        if(isset($request->dish)&& $request->file('dish')){
            $image = $request->file('dish');
            $imageName = insertData($image,'customer/documents/');
            $customer->dish = '/storage/' .$imageName;
        }
        if(isset($request->clean_up)&& $request->file('clean_up')){
            $image = $request->file('clean_up');
            $imageName = insertData($image,'customer/documents/');
            $customer->clean_up = '/storage/' .$imageName;
        }
        if(isset($request->evidence_image)&& $request->file('evidence_image')){
            $image = $request->file('evidence_image');
            $imageName = insertData($image,'customer/documents/');
            $customer->evidence_image = '/storage/' .$imageName;
        }
        if(isset($request->resume)&& $request->file('resume')){
            $image = $request->file('resume');
            $imageName = insertData($image,'customer/documents/');
            $customer->resume = '/storage/' .$imageName;
        }
        if(isset($request->is_australia)&& $request->file('is_australia')){
            $image = $request->file('is_australia');
            $imageName = insertData($image,'customer/documents/');
            $customer->is_australia = '/storage/' .$imageName;
        }
        $customer->save();
        $customer_personal_details = Customer::findOrFail($customer->customer_id);
        // $customer_personal_details->submitted = 1;
        // $customer_personal_details->save();
        // return response()->json(['redirect_url' => route('processTransaction')]);
        return back()->with(['success'=>true,'customer_id'=>$customer_personal_details->id]);
        // $data = $this->paypal->processTransaction();
        // dd($data );
        // 'customer_id'->$customer_personal_details->id
        // dd('here');
        // return redirect()->route('home');
        // return redirect()->route('processTransaction');
    }
}
