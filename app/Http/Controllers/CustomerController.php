<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\AssignedAgentMAil;
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
        Mail::to($email)->send(new RegisteredCustomer($username, $email, $password, $creator));
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

    public function storeAssignAgent(Request $request, $customerId)
    {
        // dd($request->toArray());

        // array:2 [▼ // app/Http/Controllers/CustomerController.php:113
        //     "agent" => 9
        //     "loanId" => 7
        // ]

        $useremail = User::where('id',$request->agent)->first()->email;


        $loanId = Loan::where('id',$request->loanId)->first()->user_id;
        $loanAmount = Loan::where('id',$request->loanId)->first()->loan_amount;
        $loansuser = User::where('id',$loanId)->first();


        $mailData = [
            'loansuser' => $loansuser,
            'loanAmount' => $loanAmount,
        ];

        Mail::to($useremail)->send(new AssignedAgentMAil($mailData));


        Loan::where('id',$request->loanId)->update([
            'assigned_to'=>$request->agent,
        ]);

        return redirect()->route('loan.index');


        // return Inertia::location(route('loan.index'))->with('success', 'Agent assigned successfully');

        // try {
        //     $user = User::where('id', $customerId)->update([
        //         'agent_id' => $request->agent,
        //     ]);
        //     return Inertia::location(route('customers'))->with('success', 'Agent assigned successfully');
        // } catch (\Exception $e) {
        //     return Inertia::location(route('customers'));
        // }
    }
}
