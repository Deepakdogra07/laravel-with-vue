<?php

namespace App\Http\Controllers;

use App\Models\ContactDetails;
use App\Models\InterestCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CommissionController extends Controller
{
    public function addCommission(Request $request)
    {
        // $comissionLoan = InterestCommission::where('id',1)->first();
        $comissionLoan = InterestCommission::where('id', 1)->first() ?? 0;
        return Inertia::render('AllPages/AddInterestCommission',['comissionLoan'=>$comissionLoan]);
    }
    public function saveCommission(Request $request)
    {
        $com = InterestCommission::first();
        $request->validate([
            'interest' => 'required|numeric|gte:0',
            'discount' => 'required|numeric|gte:0',
            'commission' => 'required|numeric|gte:0',
        ]);
        if (!$com) {
            $comm = new InterestCommission;
            $comm->user_id = Auth::user()->id;
            $comm->interest = $request->interest;
            $comm->discount = $request->discount;
            $comm->commission = $request->commission;
            $comm->save();
        } else {
            $com->update([
                'interest' => $request->interest,
                'discount' => $request->discount,
                'commission' => $request->commission,
            ]);
        }
    }
    public function addContact()
    {
        $contactDetails = ContactDetails::where('id',1)->first();
        return Inertia::render('AllPages/AddContactDetails',['contactDetails'=>$contactDetails]);
    }
    public function saveContact(Request $request)
    {
        $contact = ContactDetails::first();
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:11|min:0',
            'address' => 'required|string|max:255',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
            'instagram' => 'required|url',
        ]);
        if (!$contact) {
            $contact = new ContactDetails;
            $contact->user_id = Auth::user()->id;
            $contact->email = $request->email;
            $contact->phone_no = $request->phone;
            $contact->address = $request->address;
            $contact->facebookurl = $request->facebook;
            $contact->twitterurl = $request->twitter;
            $contact->instagramurl = $request->instagram;
            $contact->save();
        } else {
            $contact->update([
                'email' => $request->email,
                'phone_no' => $request->phone,
                'address' => $request->address,
                'facebookurl'=>$request->facebook,
                'twitterurl'=>$request->twitter,
                'instagramurl'=>$request->instagram,
            ]);
        }
    }
}
