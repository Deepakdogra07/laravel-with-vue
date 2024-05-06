<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredCustomer;
use App\Mail\VerifyUser;
use App\Models\User;
use App\Models\BusinessModal;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'type' => 'required',
            'company_address' => 'required',
            'company_country' => 'required',
            'company_state' => 'required',
            'company_pin' => 'required|max:10|min:4',
            'contact_number' => 'required|max:15|min:8',
            'company_name' => 'required',
            'contact_department' => 'required',
            'mobile_number' => 'required|max:15|min:8',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:4|max:10',
            'name' => 'required|unique:users',
            // 'company_vat'=>'required',
            'checkbox' => 'accepted',
        ], [
            'checkbox.accepted' => 'You must agree to the Terms of Use and Privacy Policy.',
            'company_address.required'=>"Company address is required.",
            'company_country.required'=>"Country is required.",
            'company_state.required'=>"State is required.",
            'company_pin.required'=>"Postal Code is required.",
            'company_pin.min'=>"Postal Code should be atleast 4 digits.",
            'company_pin.max'=>"Postal Code should not more than 10 digits.",
            'company_name.required'=>"Company Name is required.",
            'mobile_number.required'=>"Mobile Number is required.",
            'password.regex'=>'The password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.',
            'email.required' => 'Email is required.',
            'email.string' => 'The email must be a string.',
            'email.lowercase' => 'The email must be in lowercase letters.',
            'email.email' => 'Please enter a valid email address.            ',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'The email address is already in use.',

            'contact_department.required' => "Contact department  is required.",
            'contact_number.required' => "Contact Number  is required.",
            // 'contact_number.min' => "Contact Number  should be more than 8 digits.",
            // 'contact_number.max' => "Contact Number  should be less than 15 digits..",

            'name.required'=>"The user name is required",
            'name.unique'=>"The user name already taken. Please select other username.",

            'password.required' => 'The password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 4 characters long.',
            'password.max' => 'Password must not exceed 10 characters.',
            

        ]);
// dd($request->all());
        $textpassword = $request->password;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($textpassword),
            'phone' => $request->mobile_number,
            'user_type' => "2",
            'status' => 1,
        ]);
        $business = new BusinessModal();
        $business->company_name = $request->company_name; 
        $business->contact_number = $request->contact_number; 
        $business->company_address = $request->company_address; 
        $business->company_country_code = $request->company_country; 
        $business->company_state = $request->company_state; 
        $business->company_pin = $request->company_pin; 
        $business->contact_department = $request->test; 
        $business->company_vat = $request->company_vat; 
        $business->user_id = $user->id;
        $business->save();
        if ($user->user_type == '2') {
            $username = $user->name;
            $email = $user->email;
            $password = $textpassword;
            $creator = $user->name;
            Mail::to($email)->send(new RegisteredCustomer($username, $email, $password, $creator));
            Auth::login($user);
            Mail::to($email)->send(new VerifyUser($user->id , $username, $email, $password, $creator));
            return redirect(route('business-dash'));
        }
    }
}
