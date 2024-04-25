<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredCustomer;
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
            'company_pin' => 'required',
            'contact_number' => 'required|max:15',
            'company_name' => 'required',
            'contact_department' => 'required',
            'mobile_number' => 'required|max:15',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:4|max:10',
            'user_name' => 'required',
            'company_vat'=>'required',
            'checkbox' => 'accepted',
        ], [
            'checkbox.accepted' => 'You must agree to the Terms of Use and Privacy Policy.',
            'password.regex'=>'The password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.',
            'email.required' => 'This field is required.',
            'email.string' => 'The email must be a string.',
            'email.lowercase' => 'The email must be in lowercase letters.',
            'email.email' => 'Please enter a valid email address.            ',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'The email address is already in use.',

            'password.required' => 'The password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 4 characters long.',
            'password.max' => 'Password must not exceed 10 characters.',
            
            'company_pin.required' =>'The Pin is required',

        ]);

        $textpassword = $request->password;
        $user = User::create([
            'name' => $request->company_name,
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
        $business->save();
        if ($user->user_type == '2') {
            $user->sendEmailVerificationNotification();
            $username = $user->name;
            $email = $user->email;
            $password = $textpassword;
            $creator = $user->name;
            Mail::to($email)->send(new RegisteredCustomer($username, $email, $password, $creator));
            Auth::login($user);
            return redirect(route('business-dash'));
        }
    }
}
