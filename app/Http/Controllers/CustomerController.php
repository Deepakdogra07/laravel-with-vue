<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\VerifyUser;
use App\Models\Customer;
use App\Models\JobStatus;
use App\Models\Industries;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BusinessModal;
use App\Mail\RegisteredCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        // if ($authUser->user_type == 1) {
        $customers = User::where('user_type', '=', '3')->latest()->get();
        // }

        return Inertia::render('Customers/Index', ['customers' => $customers,'authUser'=>$authUser]);
    }
    public function show()
    {
        return Inertia::render('Customers/AddCustomer');
    }
    public function add(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', 'min:4'],
            'phone' => 'required|numeric|min:7',
            'password_confirmation' => 'required',
        ]);
        $textpassword = $request->password;
        $user = User::create(
            [
                'user_type' => $request->user_type,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($textpassword),
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => ($request->status == true) ? 1 :0,
            ]);

        // $user->sendEmailVerificationNotification();



        $username = $user->name;
        $email = $user->email;
        $password = $textpassword;
        $creator = Auth::user()->name;
        Mail::to($email)->send(new RegisteredCustomer($username, $email, $password, $creator));
        Mail::to($email)->send(new VerifyUser($user->id , $username, $email, $password, $creator));
        return to_route('customers');
    }

    public function view(Request $request, $id)
    {
        $id = intval($id);
        $customer = User::where('id', $id)->first();
       
        return Inertia::render('Customers/ViewCustomer', ['customer' => $customer]);
    }
    public function edit(Request $request)
    {
        $customer = User::where('id', $request->id)->first();
        return Inertia::render('Customers/EditCustomer', ['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|max:10|min:8',
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => ($request->status == true) ? 1 :0,
        ]);
        return to_route('customers');
    }

    public function delete(Request $request)
    {
        $customers = User::find($request->id);
        JobStatus::where('customer_id', $request->id)->each(function ($jobStatus) {
            $jobStatus->customers()->each(function ($customer) {
                $customer->travel_details()->forceDelete();            
                $customer->documents()->forceDelete();
                $customer->employments()->forceDelete();
                $customer->forceDelete();
            });
            $jobStatus->forceDelete();
        });
        $customers->forceDelete();
    }
    public function createBusiness(){
        $user = Auth::user();
        if($user){
            return Inertia::render('Customer/RegisterBusiness',compact('user'));
        }else{
            return redirect()->route('403');
        }
    }


    public function registerCustomer(Request $request){
    //    dd($request->all());
        $user_id = $request->user_id;
       $validatedData = $request->validate([
        'type' => 'required',
        'company_address' => 'required',
        'company_country' => 'required',
        'company_state' => 'required',
        'company_pin' => 'required',
        'contact_number' => 'required',
        'company_name' => 'required',
        'contact_department' => 'required',
        'mobile_number' => 'required|string|min:8|max:15|regex:/^[0-9]+$/',
        'email' => 'required|email|unique:users,email,'.$user_id.'|max:255',
        'company_city'=>'required',
        'checkbox' => 'accepted',
    ], [
        'checkbox.accepted' => 'You must agree to the Terms of Use and Privacy Policy.',
        'company_address.required'=>"Company address is required.",
        'company_country.required'=>"Country is required.",
        'company_state.required'=>"State is required.",
        'company_city.required'=>"City is required.",
        'company_pin.required'=>"Postal Code is required.",
        'company_name.required'=>"Company name is required.",
        'mobile_number.required'=>"Mobile number is required.",
        'mobile_number.regex'=>"Mobile number must be a number.",
        'mobile_number.min'=>"Mobile number must be at least 8 digits.",
        'mobile_number.max'=>"Mobile number must not be more than 15 digits.",
        'password.regex'=>'The password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.',
        'email.required' => 'Email is required.',
        'email.string' => 'The email must be a string.',
        'email.lowercase' => 'The email must be in lowercase letters.',
        'email.email' => 'Please enter a valid email address.            ',
        'email.max' => 'Email must not exceed 255 characters.',
        'email.unique' => 'The email address is already in use.',

        'contact_department.required' => "Contact department  is required.",
        'contact_number.required' => "Contact Person  is required.",
    ]);
        $user = User::find($request->user_id);
        $user->user_type = 2;
        $user->save();
        $business = new BusinessModal();
        $business->company_name = $request->company_name; 
        $business->contact_number = $request->contact_number; 
        $business->company_address = $request->company_address; 
        $business->company_country_code = $request->company_country; 
        $business->company_state = $request->company_state; 
        $business->company_pin = $request->company_pin; 
        $business->contact_department = $request->contact_department; 
        $business->company_vat = $request->company_vat; 
        $business->company_city = $request->company_city; 
        $business->user_id = $user_id;
        $business->save();
        return redirect()->route('home');
    }

    public function view_customer($customer_id){
        $user_type = Auth::user()->user_type;
        $customer = Customer::where('id',$customer_id)->with('travel_details','status','documents','employments','transactions','jobs','jobs.business')->first();
        $industry_id = json_decode($customer->jobs->industry_id);
        $industries = Industries::WhereIn('id',$industry_id)->pluck('category_heading')->toArray();
        return Inertia::render('Business/ViewCustomer',compact('customer','user_type','industries'));
    }
    
}
