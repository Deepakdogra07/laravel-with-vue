<?php

namespace App\Http\Controllers;


use App\Models\User;
use Inertia\Inertia;
use App\Models\Leads;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisteredAgent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        if ($authUser->user_type == 1) {
        $customers = User::where('user_type', '=', '3')->where('is_deleted', 0)->get();
        }elseif($authUser->user_type == 2){
            $customers = User::where('user_type', '=', '3')->where('is_deleted', 0)->get();
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', 'min:4'],
            'phone' => 'required|numeric|min:7',
            'password_confirmation' => 'required',
        ]);
        $referralCode = Str::random(10);
        $textpassword = $request->password;
        $user = User::create(
            [
                'user_type' => $request->user_type,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($textpassword),
                'address' => $request->address,
                'phone' => $request->phone,
                'referralcode' => $referralCode,
                'status' => $request->status,
            ]);

        $user->sendEmailVerificationNotification();



        $username = $user->name;
        $email = $user->email;
        $password = $textpassword;
        $creator = Auth::user()->name;
        Mail::to($email)->send(new RegisteredAgent($username, $email, $password, $creator));
    }

    public function view(Request $request, $id)
    {
        $id = intval($id);
        $customer = User::where('id', $id)->where('is_deleted', 0)->first();
        // dd($customer);
        return Inertia::render('Customers/ViewCustomer', ['customer' => $customer]);
    }
    public function edit(Request $request)
    {
        $customer = User::where('id', $request->id)->where('is_deleted', 0)->first();
        return Inertia::render('Customers/EditCustomer', ['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|numeric|digits:11',
            // 'address' => 'required',
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
        ]);
    }

    public function delete(Request $request)
    {
        $customers = User::find($request->id);
        $customers->update(['is_deleted' => 1]);
    }
}
