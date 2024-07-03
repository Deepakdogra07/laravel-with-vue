<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\JobStatus;
use App\Models\Transactions;
use Inertia\Inertia;
use Illuminate\Http\Request;
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
        // dd('paypal');
        $amount = '20.00';
        $country = 'AUD';
        // $customer = $customer_id;
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
            // return response()->json(['success'=>false,'message'=>'Something went wrong.']);
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
        if(Transactions::where('customer_id',$customer_id)->exists()){
            return redirect()->route('home')->with(['success'=>false,'message'=>'Order Already Paid.']);
        }
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
            return redirect()->route('home')->with(['success'=>true,'message'=>'Payment Added .']);
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
