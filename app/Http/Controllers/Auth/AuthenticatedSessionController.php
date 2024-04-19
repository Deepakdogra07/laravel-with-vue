<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\FooterData;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{

    /**
     * Display the login view.
     */
    public function create(Request $request): Response
    {    
      $footer_data = FooterData::first();
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
            'footer_data'=>$footer_data,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $CheckActive = User::where('email', $request->email)->first()->status ?? 0; 


        $userExists = User::where('email', $request->email)->exists();

        $rules = [];

        // Add your validation rules here if needed

       $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($CheckActive == 0 && $userExists){
            // email
            $validator->errors()->add('email', "Your account is inactive. Please contact the admin.");
             return redirect()->back()->withErrors($validator)->withInput();
        }




        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->user_type == '3') {
            return redirect()->intended(route('business-dash'));
        } else {
            return redirect()->route('dashboard');
        }

    }

    /**
     * Destroy an authenticated session.
     */
     function destroy(Request $request): RedirectResponse
    {

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();

        // $preserveData = Session::get('preserve_data');

        if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            Auth::guard('web')->logout();
            return redirect('/admin');
        }else{
            Auth::guard('web')->logout();

            return redirect('/');
        }

    }
    }

