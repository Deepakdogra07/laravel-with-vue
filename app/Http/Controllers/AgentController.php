<?php

namespace App\Http\Controllers;


use App\Models\Jobs;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Leads;
use App\Mail\VerifyUser;
use App\Models\JobStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisteredAgent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Notifications\VerifyEmail;

class AgentController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $customers = User::where('user_type', '2')->latest()->get();
        return Inertia::render('Admin/Business/Index', ['customers' => $customers,'authUser'=>$authUser]);
    }
    public function create()
    {
        return Inertia::render('Admin/Business/Create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
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
                'status' => $request->status,
            ]);

        // $user->sendEmailVerificationNotification();



        $username = $user->name;
        $email = $user->email;
        $password = $textpassword;
        $creator = Auth::user()->name;
        Mail::to($email)->send(new VerifyUser(Auth::user()->id,$username, $email, $password, $creator));
        Mail::to($email)->send(new RegisteredAgent($username, $email, $password, $creator));
        return to_route('business-listing.index');
    }

    public function view(Request $request, $id)
    {
        $id = intval($id);
        $customer = User::where('id', $id)->first();
        // dd($customer);
        return Inertia::render('Customers/ViewCustomer', ['customer' => $customer]);
    }
    public function edit($id)
    {
        $customer = User::where('id', $id)->first();
        return Inertia::render('Admin/Business/Edit', ['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|min:8|max:15',
        ]);

        User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
        ]);
        return to_route('business-listing.index');
    }

    public function destroy($id)
    {
        // dd($request->all());
        $customer = User::find($id);
        Jobs::where('user_id',$customer->id)->forceDelete();
        JobStatus::where('customer_id', $customer->id)->each(function ($jobStatus) {
            $jobStatus->customers()->each(function ($customer) {
                $customer->travel_details()->forceDelete();            
                $customer->documents()->forceDelete();
                $customer->employments()->forceDelete();
                $customer->forceDelete();
            });
            $jobStatus->forceDelete();
        });
        $customer->forceDelete();

    }
}
