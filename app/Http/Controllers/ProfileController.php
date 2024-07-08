<?php

namespace App\Http\Controllers;

use App\Models\BusinessModal;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Withdraw;
use App\Models\FooterData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $business = BusinessModal::where('user_id',Auth::user()->id)->first();
        $auth_type = Auth::user()->user_type;
        if($auth_type!=1){
            $footer_data = FooterData::first();
            return Inertia::render('Profile/EditUser', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
                'business' => $business,
                'auth_type' => $auth_type,
                'footer_data'=>$footer_data
            ]);
        }
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'auth_type' => $auth_type,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        if($user->user_type == 2){
            BusinessModal::where('user_id',$user->id)->delete();
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function editProfile(Request $request)
    {
        $acountDetails = null;
        $userData = User::where('id',$request->user()->id)->first();
        return Inertia::render('Frontend/Profile/Edit',['userData'=> $userData,'acountDetails'=>$acountDetails]);
    }

    public function update_business(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'company_name' => 'required',
            'company_address' => 'required',
            'contact_number' => 'required',
            'company_country_code' => 'required',
            'company_state' => 'required',
            'company_pin' => 'required',
            
        ], [
            'checkbox.accepted' => 'You must agree to the Terms of Use and Privacy Policy.',
            'company_address.required'=>"Company address is required.",
            'company_country_code.required'=>"Country is required.",
            'company_state.required'=>"State is required.",
            'company_city.required'=>"City is required.",
            'company_pin.required'=>"Postal Code is required.",
            // 'company_pin.min'=>"Postal Code should be atleast 4 digits.",
            // 'company_pin.max'=>"Postal Code should not more than 10 digits.",
            'company_name.required'=>"Company Name is required.",
            'mobile_number.required'=>"Mobile Number is required.",
            'mobile_number.regex'=>"Mobile Number must be a number.",
            'mobile_number.min'=>"Mobile Number must be at least 8 digits.",
            'mobile_number.max'=>"Mobile Number must not be more than 15 digits.",
            'password.regex'=>'The password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.',
            'email.required' => 'Email is required.',
            'email.string' => 'The email must be a string.',
            'email.lowercase' => 'The email must be in lowercase letters.',
            'email.email' => 'Please enter a valid email address.            ',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'The email address is already in use.',

            'contact_department.required' => "Contact department  is required.",
            'contact_number.required' => "Contact Person  is required",

        ]);
        $business = BusinessModal::findOrFail($request->id);
        if($business){
            $data = $request->except('id','user_id');
            $business->update($data);
        }
        return Redirect::route('profile.edit');
    }

    public function userProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $userProfile = User::where('id',$userId)->first();
        return Inertia::render('Frontend/Profile/index',compact('userProfile'));
    }
}
