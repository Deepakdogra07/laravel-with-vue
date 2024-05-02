<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    // public function __invoke(EmailVerificationRequest $request): RedirectResponse
    // {
    //     dd('here');
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    //     }

    //     if ($request->user()->markEmailAsVerified()) {

    //      if (Auth::check()) {
    //         Auth::logout();
    //     }
    //         event(new Verified($request->user()));
    //     }

    //     return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    // }
    public function verify_email($id){
        $data = User::where('id',$id)->pluck('email_verified_at')->first();
        if(!$data){
            $data =User::where('id',$id)->update(['email_verified_at'=>Carbon::now()]);
        }
        return redirect()->intended(RouteServiceProvider::HOME)->with('msg', 'Email verified successfully');
    }
}
