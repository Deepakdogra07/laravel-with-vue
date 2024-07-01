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
