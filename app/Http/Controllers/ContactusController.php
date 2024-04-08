<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Contactus;
use App\Mail\ContactusMail;
use Illuminate\Http\Request;
use App\Models\ContactDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ContactusController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $contactDetails = ContactDetails::where('id',1)->first();
       return Inertia::render('Frontend/Contactus/create',['contactDetails'=>$contactDetails]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9]{11}$/',
            'message' => 'required|string',
        ];

        $messages = [
            'name.required' => 'Este campo é obrigatório.',
            'name.string' => 'Name must be type of string',
            'name.max' => 'Name Must Be maximum 255 digit',

            'email.required' => 'Este campo é obrigatório.',
            'email.email' => 'E-mail Deve ser o tipo de e-mail.',
            'email.max' => 'O nome deve ter no máximo 255 dígitos.',

            'phone.required' => 'Este campo é obrigatório.',
            'phone.regex' => 'O número de telefone deve ser numérico e pode ter no máximo 11 dígitos.',

            'phone.max' => 'O número de telefone não deve exceder 11 caracteres.',

            'message.required' => 'Este campo é obrigatório.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $mailData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];

        $contactDetails = DB::table('contacts_details')->where('id',1)->get();
        if($contactDetails->isNotEmpty()){
            $superadmin = DB::table('contacts_details')->where('id',1)->first()->email;
        }else{
          $superadmin = User::where('user_type',1)->first()->email;
        }

        Mail::to($request->email)->send(new ContactusMail($mailData));

        Mail::to($superadmin)->send(new ContactusMail($mailData));


        Contactus::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'position'=>$request->position ?? '',
            'message'=>$request->message,
        ]);

        return Redirect::to('/');
    }
}
