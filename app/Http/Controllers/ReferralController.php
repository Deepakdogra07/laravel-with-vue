<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Mail\WithDrawlAcceptMail;
use App\Models\InterestCommission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RejectedReasonWithdrawl;

class ReferralController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 1) {
            $user = '';
            $code_user = User::join('loans', 'loans.user_id', '=', 'users.id')
                ->leftJoin('status', 'status.value', '=', 'loans.status')
                ->whereNotNull('loans.referralLink')
                ->select('loans.id','loans.commission', 'loans.applicant_name', 'loans.loan_amount', 'status.name as status', 'loans.referralLink', 'loans.wallet_commission')
                ->get();

            $loan_users = [];
            foreach ($code_user as $record) {
                $loan_user = User::where('users.referralcode', '=', $record->referralLink)
                    ->select('users.name as name', 'users.referralcode as referralcode')
                    ->get()->toArray();
                $loan_users[] = $loan_user;
            }

            $commission = [];

            $combined_users = [];
            for ($i = 0; $i < count($code_user); $i++) {
                if (!empty($loan_users[$i])) {
                    $code_user_array = $code_user[$i]->toArray();
                    $loan_user_array = $loan_users[$i][0];
                    $combined_users[$i] = array_merge($code_user_array, $loan_user_array, $commission);
                }
            }
        } elseif (Auth::user()->user_type == 2) {
            $user = Auth::user();
                $code_user = Loan::where('loans.referralLink', '=', $user->referralcode)
                    ->leftJoin('status', 'status.value', '=', 'loans.status')
                    ->whereNotNull('loans.referralLink')
                    ->select('loans.id', 'loans.applicant_name', 'status.name as status', 'loans.referralLink', 'loans.commission')
                    ->get();
                $loan_users = [];
                foreach ($code_user as $record) {
                    $loan_user = User::where('users.referralcode', '=', $record->referralLink)
                        ->select('users.name as name', 'users.referralcode as referralcode')
                        ->get()->toArray();
                    $loan_users[] = $loan_user;
                }

                $commission = [];

                $combined_users = [];
                for ($i = 0; $i < count($code_user); $i++) {
                    if (!empty($loan_users[$i])) {
                        $code_user_array = $code_user[$i]->toArray();
                        $loan_user_array = $loan_users[$i][0];
                        $combined_users[$i] = array_merge($code_user_array, $loan_user_array, $commission);
                    }
                }
        }

        return Inertia::render('Referrals/Index', ['combined_users' => $combined_users,
         'auth_user' => $user
        ]);
    }
    public function adminIndex()
    {
        if (Auth::check()) {
            $code_user = Auth::user();
            $discount = InterestCommission::select('discount')->first();
            $loan_users = Loan::leftjoin('status', 'status.value', '=', 'loans.status')
                ->where('loans.discount_code', '=', $code_user->referralcode)
                ->select('loans.id', 'loans.applicant_name', 'loans.loan_amount',
                 'status.name as status', 'loans.discount_code','loans.discountcodevalue',
                 'loans.commission'
                 )
                ->get()->toArray();



            if ($discount !== null) {
                $discount = $discount->toArray();
            } else {
                $discount = [];
            }

            $combined_users = [];
            $super_admin = [
                'admin' => $code_user->name,
                'status' => null,
                'discount_code' => $code_user->referralcode,
            ];
            if (!empty($loan_users)) {
                foreach ($loan_users as $loan_user) {
                    $combined_users[] = array_merge($super_admin, $loan_user, $discount);

                }
            }

            return Inertia::render('Referrals/AdminIndex', ['combined_users' => $combined_users]);
        }
    }

    public function indexWithdraw()
    {
        if(Auth::user()->user_type == 1){
            $withdraws = DB::table('withdraws')
                ->join('users', 'withdraws.user_id', '=', 'users.id')
                ->select('withdraws.id as withdraw_id', 'withdraws.*', 'users.name', 'withdraws.status',)
                ->get();
        }else{
            $withdraws = DB::table('withdraws')
            ->join('users', 'withdraws.user_id', '=', 'users.id')
            ->select('withdraws.id as withdraw_id', 'withdraws.*', 'users.*', 'withdraws.status') // Select withdraws.id as withdraw_id
            ->get();
        }

        return Inertia::render('Withdrawals/Index', ['withdraws' => $withdraws]);
    }
    public function receiptForm($id)
    {
        return Inertia::render('Withdrawals/ReceiptForm', ['id' => $id]);
    }
    public function receiptAdd(Request $request)
    {
        $userId = Withdraw::where('id',$request->withdrawId['id'])->first()->user_id;
        $userEmail = User::where('id',$userId)->first()->email;

        $amount = Withdraw::where('id',$request->withdrawId['id'])->first()->withdrawAmount;

        $request->validate([
            'receipt' => 'required|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);

        $mailData = [
            'userEmail' => $userEmail,
            'amount' => $amount,
        ];

        Mail::to($userEmail)->send(new WithDrawlAcceptMail($mailData));


        $originalName = $request->file('receipt')->getClientOriginalName();
        $path = $request->file('receipt')->storeAs('Receipts', $originalName, 'public');

        try {
            Withdraw::where('id', $request->withdrawId)
                    ->update([
                        'status' => 1,
                        'receipt' => $path,
                    ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }
    public function reasonForm($id)
    {
        return Inertia::render('Withdrawals/ReasonForm', ['id' => $id]);
    }
    public function reasonAdd(Request $request)
    {
        $request->validate([
            'receipt' => 'required',
        ]);

        $user_email_id = Withdraw::where('id',$request->withdrawId['id'])->first()->user_id;

        $rejLoanAmount =  Withdraw::where('id',$request->withdrawId['id'])->first()->withdrawAmount;

        // dd($rejLoanAmount);

        $userEmailRecord = User::where('id',$user_email_id)->first()->email;

        $mailData = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp.',
            'amount' => $rejLoanAmount,
        ];

        Mail::to($userEmailRecord)->send(new RejectedReasonWithdrawl($mailData));

        $rows = Withdraw::where('id', '=', $request->withdrawId)
            ->update([
                'status' => 2,
                'receipt' => $request->receipt,
            ]);
    }
}
