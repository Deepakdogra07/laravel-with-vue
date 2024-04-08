<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardData(){
        $user = Auth::user();
        if ($user->user_type == 1) {
            $totalUsers = User::where('user_type',3)->where('is_deleted',0)->get();
            $totalAgent = User::where('user_type',2)->where('is_deleted',0)->get();
            // $loanData = Loan::where('is_deleted',0)->get();
            $loanData = Loan::
                leftjoin('status', 'status.value', '=', 'loans.status')
                ->where('is_deleted', 0)
                ->orderBy('id', 'desc')
                ->select('loans.*', 'status.name as status','status.value as statusValue')
                ->get();
                $totalRejectLoan = Loan::where('status',2)->get();
                $totalRejectLoanCount = count($totalRejectLoan);
            // $approvedLoan = Loan::with('getAgent')->where('status',2)->where('is_deleted',0)->get();
            $approvedLoan = Loan::with('getAgent')
                ->leftjoin('status', 'status.value', '=', 'loans.status')
                ->where('is_deleted', 0)
                ->where('status',1)
                ->orderBy('id', 'desc')
                ->select('loans.*', 'status.name as status','status.value as statusValue')
                ->get();
        }elseif ($user->user_type == 2){
            $totalUsers = User::where('user_type',3)->where('is_deleted',0)->get();


            $totalAgent = [];
            $loanData = [];

            $approvedLoan = [];


            if ($totalUsers) {
                $userIds = $totalUsers->pluck('id')->toArray();
                $loanData = Loan::
                leftjoin('status', 'status.value', '=', 'loans.status')
                ->where('is_deleted', 0)->where('assigned_to',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->select('loans.*', 'status.name as status','status.value as statusValue')
                ->whereIn('user_id', $userIds)->get();

                $approvedLoan = Loan::with('getAgent')
                ->leftjoin('status', 'status.value', '=', 'loans.status')
                ->where('is_deleted', 0)
                ->where('status',1)->where('assigned_to',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->select('loans.*', 'status.name as status','status.value as statusValue')
                ->whereIn('user_id', $userIds)->get();

                $totalRejectLoan = Loan::where('status',2)->where('assigned_to',Auth::user()->id)->get();
                $totalRejectLoanCount = count($totalRejectLoan);
            }

        }
        $totalAgentCount = count($totalAgent);

        return Inertia::render('Dashboard', [ 'totalAgentCount'=>$totalAgentCount ,'totalRejectLoanCount'=>$totalRejectLoanCount,'authData'=>$user,'users' => $totalUsers,'loan'=>$loanData,'approvedLoan'=>$approvedLoan,'totalAgent'=>$totalAgent]);
    }

}
