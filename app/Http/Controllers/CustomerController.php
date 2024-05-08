<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\VerifyUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisteredCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        if ($authUser->user_type == 1) {
        $customers = User::where('user_type', '=', '3')->where('is_deleted',null)->get();
        }elseif($authUser->user_type == 2){
            $customers = User::where('user_type', '=', '3')->where('is_deleted', null)->get();
        }

        return Inertia::render('Customers/Index', ['customers' => $customers,'authUser'=>$authUser]);
    }
    public function show()
    {
        return Inertia::render('Customers/AddCustomer');
    }
    public function add(Request $request)
    {
        
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', 'min:4'],
            'phone' => 'required|numeric|min:7',
            'password_confirmation' => 'required',
        ]);
        $textpassword = $request->password;
        $user = User::create(
            [
                'user_type' => $request->user_type,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($textpassword),
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => ($request->status == true) ? 1 :0,
            ]);

        // $user->sendEmailVerificationNotification();



        $username = $user->name;
        $email = $user->email;
        $password = $textpassword;
        $creator = Auth::user()->name;
        Mail::to($email)->send(new RegisteredCustomer($username, $email, $password, $creator));
        Mail::to($email)->send(new VerifyUser($user->id , $username, $email, $password, $creator));
        return to_route('customers');
    }

    public function view(Request $request, $id)
    {
        $id = intval($id);
        $customer = User::where('id', $id)->first();
       
        return Inertia::render('Customers/ViewCustomer', ['customer' => $customer]);
    }
    public function edit(Request $request)
    {
        $customer = User::where('id', $request->id)->first();
        return Inertia::render('Customers/EditCustomer', ['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|max:10|min:8',
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => ($request->status == true) ? 1 :0,
        ]);
        return to_route('customers');
    }

    public function delete(Request $request)
    {
        $customers = User::find($request->id);
        $customers->update(['is_deleted' => 1]);
    }

    
}
