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

            'name' => 'required|string|max:255|alpha',
            'email' => 'required|string|email|max:255|unique:' . User::class,

            // 'password' => ['required', 'confirmed', 'min:6', 'max:8'],
            'password' => ['required', 'confirmed', 'min:4'],
            // 'address' => 'required',
            'phone' => 'required|digits:11',
            'checkbox' => 'accepted',
        ], [
            'name.alpha' => 'O campo do nome deve conter apenas letras.',
            'checkbox.accepted' => 'Você deve concordar com os Termos de Uso e a Política de Privacidade.',
            'name.required' => 'Este campo é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não deve exceder 255 caracteres.',
            'password.regex'=>'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um dígito e um caractere especial.',
            'email.required' => 'Este campo é obrigatório.',
            'email.string' => 'O e-mail deve ser uma string.',
            'email.lowercase' => 'O e-mail deve estar em letras minúsculas.',
            'email.email' => 'Por favor insira um endereço de e-mail válido.',
            'email.max' => 'O e-mail não deve exceder 255 caracteres.',
            'email.unique' => 'O endereço de e-mail já está em uso.',

            'password.required' => 'Este campo é obrigatório.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.min' => 'A senha deve ter pelo menos 4 caracteres.',
            'password.max' => 'A senha não deve exceder 8 caracteres.',

            'dob.required' => 'Este campo é obrigatório.',

            'address.required' => 'Este campo é obrigatório.',

            'phone.required' => 'Este campo é obrigatório.',
            'phone.digits' => 'O número de telefone deve ter exatamente 11 dígitos.',

            'gender.required' => 'Este campo é obrigatório.',

            'interests.required' => 'Este campo é obrigatório.',
        ]);

        $referralCode = Str::random(10);
        $textpassword = $request->password;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($textpassword),
            // 'address' => $request->address,
            'phone' => $request->phone,
            'referralcode' => $referralCode,
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
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
