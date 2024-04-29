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
        $data = Contactus::latest()->get();
        return Inertia::render('Admin/Enquiry/Enquiries',compact('data'));

    }

    public function create()
    {
        $contactDetails = ContactDetails::where('id',1)->first();
       return Inertia::render('Frontend/Contactus/create',['contactDetails'=>$contactDetails]);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_mobile' => 'required|min:8|max:15',
            'user_message' => 'required|string',
        ];

        $messages = [
            'user_name.required' => 'Name field is required',
            'user_name.string' => 'Name must be type of string',
            'user_name.max' => 'Name Must Be maximum 255 digit',

            'user_email.required' => 'Email field is required',
            'user_email.email' => 'Email must be in valid format.',
            'user_email.max' => 'Email must be less than 255 digits.',

            'user_mobile.required' => 'Mobile Number field is required',
            'user_mobile.min' => 'Mobile Number should be not less than 8 digits. ',
            'user_mobile.max' => 'Mobile Number should be not more than 15 digits. ',

            'user_message.required' => 'Message field is required',
        ];

        $validatedData = $request->validate($rules, $messages);

        $mailData = [
            'name' => $request->user_name,
            'email' => $request->user_email,
            'phone' => $request->user_mobile,
            'message' => $request->user_message,
        ];

          $superadmin = User::where('user_type',1)->pluck("email")->first();
        

        Mail::to([$request->user_email,$superadmin])->send(new ContactusMail($mailData));

        Contactus::create([
            'user_name'=>$request->user_name,
            'user_email'=>$request->user_email,
            'user_mobile'=>$request->user_mobile,
            'user_message'=>$request->user_message,
        ]);

        return Redirect::to('/');
    }
    public function view($id){
        $enquiry = Contactus::where('id',$id)->first();
        return Inertia::render('Admin/Enquiry/View',compact('enquiry'));
    }
}
