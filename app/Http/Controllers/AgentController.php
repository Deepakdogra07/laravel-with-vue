<?php

namespace App\Http\Controllers;

use App\Models\Loan;
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
        $agents = User::where('user_type', '=', '2')->where('is_deleted', 0)->orderBy('id', 'desc')->get();
        return Inertia::render('Agents/Index', ['agents' => $agents,'authUser'=>$authUser]);
    }
    public function show()
    {
        return Inertia::render('Agents/AddAgent');
    }
    public function add(Request $request)
    {
        // dd("Hello ! ");
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed','min:4'],
            'phone'=>'required|numeric|digits:11',
            // 'address'=>'required',
            'password_confirmation'=> 'required',
        ]);
        $referralCode = Str::random(10);
        $users = User::create([
            'user_type' => $request->user_type,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address'=> $request->address,
            'phone'=> $request->phone,
            'referralcode' => $referralCode,
            'status' => $request->status,
        ]);

        $users->sendEmailVerificationNotification();
        // Auth::login($users);

        $username = $users->name;
        $email = $users->email;
        $password = $request->password;
        $creator = Auth::user()->name;
        // dd($password);
        // $apassword = $request->password;

        Mail::to($email)->send(new RegisteredAgent($username, $email, $password, $creator));
    }

    public function view(Request $request)
    {
        $agent = User::where('id', $request->id)->where('is_deleted', 0)->first();
        return Inertia::render('Agents/ViewAgent', ['agent' => $agent]);
    }

    public function edit(Request $request)
    {
        $agent = User::where('id', $request->id)->where('is_deleted', 0)->first();
        return Inertia::render('Agents/EditAgent', ['agent' => $agent]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone'=>'required|numeric|digits:11',
            // 'address'=>'required',
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
        $agents = User::find($request->id);
        $agents->update(['is_deleted' => 1]);
    }
    public function listing()
    {
        // $agents = User::where('user_type', '=', '2')
        //     ->where('users.is_deleted', 0)
        //     ->orderBy('users.id', 'desc')
        //     ->leftJoin('loans', 'loans.assigned_to', '=', 'users.id')
        //     ->select('users.*', DB::raw('GROUP_CONCAT(loans.applicant_name) as lead_name'))
        //     ->groupBy('users.id', 'users.name')
        //     ->get();

        $agents = User::where('user_type', '=', '2')
            ->where('users.is_deleted', 0)
            ->orderBy('users.id', 'desc')
            ->leftJoin('loans', 'loans.assigned_to', '=', 'users.id')
            ->select('users.*', DB::raw('GROUP_CONCAT(loans.applicant_name) as lead_name'), DB::raw('COUNT(loans.assigned_to) as loan_count'))
            ->groupBy('users.id', 'users.name')
            ->get();






        // dd($agents->toarray());

        return Inertia::render('Agents/Listing', ['agents' => $agents]);
    }
    public function agentBasedLeads(Request $request)
    {
        // dd($request->id);
        // $leads = Loan::where('loans.assigned_to', $request->id)
        // ->leftJoin('status','status.value','loans.status')
        // ->where('loans.is_deleted', 0)
        // ->select('loans.*','status.name as status')
        // ->orderBy('loans.id','desc')
        // ->get();


        $leads = Loan::where('assigned_to',$request->id)->where('is_deleted',0)->get();
        // dd($leads);


    ;
        return Inertia::render('Agents/AgentBasedLead', ['leads' => $leads]);
    }
    public function cancelAgent(Request $request, $id)
    {
        //    dd($id);
        // $leads = Leads::where('id', $id)
        //     ->update(['agent_id' => 0]);

        $leads = Loan::where('id', $id)
        ->update(['assigned_to' => 0]);
        return redirect()->back();
    }
}
