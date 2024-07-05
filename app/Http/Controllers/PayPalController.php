<?php
namespace App\Http\Controllers;

use App\Mail\Transaction;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Jobs;
use App\Models\JobStatus;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    // public function createTransaction()
    // {
    //     return Inertia::render('Frontend/CustomerSection/Transaction/Transaction');
    // }
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction($customer_id)
    {
        if(Transactions::where('customer_id',$customer_id)->exists()){
            return redirect()->route('home')->with(['success'=>false,'message'=>'Order Already Paid.']);
        }
        $amount = '20.00';
        $country = 'AUD';
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction',$customer_id),
                "cancel_url" => route('cancelTransaction',$customer_id),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $country,
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('home')->with(['success'=>false]);
        } else {
            return redirect()->route('home');
        }
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request,$customer_id = null)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);  
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $transaction = Transactions::create([
                'customer_id' =>$customer_id,
                'transaction_id' => $response['id'],
                'transaction_status' => $response['status'],
                'status' => 0
            ]);
            $customer_personal_details = Customer::findOrFail($customer_id);
            $customer_personal_details->submitted = 1;
            $customer_personal_details->save();
            $user = User::where('id',$customer_personal_details->user_id)->first();
            $job = Jobs::where('id',$customer_personal_details->job_id)->pluck('job_title')->first();
            $jobstatus = JobStatus::where('customer_id',$customer_personal_details->id)->pluck('status')->first();
            Mail::to($user->email)->send(new Transaction($user->id , $user->name, $user->email,$transaction->transaction_id,$job,$jobstatus,$transaction->transaction_status));
            return redirect()->route('home')->with(['success'=>true,'message'=>'Job Applied Successfully.']);
        } else {
            return redirect()->route('home')->with(['success'=>false,'message'=>'Order Already Paid.']);
        }

    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request,$customer_id = null)
    {
        return redirect()->route('home')->with(['success'=>false,'message'=>'You Cancelled the transaction.']);
    }

    
}
