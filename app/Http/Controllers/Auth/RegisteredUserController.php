<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredCustomer;
use App\Models\User;
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

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,

            // 'password' => ['required', 'confirmed', 'min:6', 'max:8'],
            'password' => ['required', 'confirmed', 'min:4'],
            // 'address' => 'required',
            'phone' => 'required|digits:10',
            'checkbox' => 'accepted',
        ], [
            'checkbox.accepted' => 'Você deve concordar com os Termos de Uso e a Política de Privacidade.',
            'name.required' => 'Name is required.',
            'name.string' => 'Name should only in alphabets.',
            'name.max' => 'Name should not exceeds 255 characters.',
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
            'password.max' => 'Password must not exceed 8 characters.',

            'dob.required' => 'This field is required.',

            'address.required' => 'This field is required.',

            'phone.required' => 'This field is required.',
            'phone.digits' => 'The phone number must be exactly 10 digits long.',

            'gender.required' => 'This field is required.',

            'interests.required' => 'This field is required.',
        ]);

        $textpassword = $request->password;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($textpassword),
            'phone' => $request->phone,
            'user_type' => "3",
            'status' => 1,
        ]);
        if ($user->user_type == '3') {
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
