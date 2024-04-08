<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\Loan;
use App\Models\Status;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Leads::leftjoin('users', 'users.id', '=', 'leads.agent_id')->select('leads.*', 'users.name as agent')->get();
        // dd($leads);
        return Inertia::render('Leads/Index', ['leads' => $leads]);
    }

    public function access_token_by_code()
    {
        $client_id = config('rdstation.client_id');
        $client_secret = config('rdstation.client_secret');
        $redirectUri = config('rdstation.redirect_uri');
        $code = config('rdstation.code');
        // dd($client_id,
        // $client_secret,
        // $redirectUri,
        // $code);
        if (!$code) {
            return response()->json(['error' => 'Authorization code not found in the request.'], 400);
        }
        $client = new Client();

        $response = $client->request('POST', 'https://api.rd.services/auth/token?token_by=code', [
            'body' => '{"client_id":"' . $client_id . '","client_secret":"' . $client_secret . '","code":"' . $code . '"}',
            'headers' => [
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        $result = json_decode($response->getBody());
        // dd(Carbon::now()->addHours(23));

        $token = new Token;
        $token->access_token = $result->access_token;
        $token->expires_in = Carbon::now()->addHours(23);
        $token->refresh_token = $result->refresh_token;
        $token->save();

        return response()->json(['data' => $result]);

        // dd($result->access_token, $result->refresh_token);
    }

    public function access_token_by_refresh_token()
    {
        $token = Token::orderBy('id', 'desc')->first();

        if (Carbon::now()->addHours(24) > $token->expires_in) {
            $client_id = config('rdstation.client_id');
            $client_sec = config('rdstation.client_secret');
            $refresh_toke = Token::first();
            $refresh_token = $refresh_toke->refresh_token;
            $client = new Client();
           
            $response = $client->request('POST', 'https://api.rd.services/auth/token', [
                'body' => '{"client_id":"' . $client_id . '","client_secret":"' . $client_sec . '","refresh_token":"' . $refresh_token . '"}',
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);
            $result = json_decode($response->getBody(), true);
            $token->update([
                'access_token' => $result['access_token'],
                'expires_in' => now()->addSeconds($result['expires_in']),
                'refresh_token' => $result['refresh_token'],
            ]);
            return response()->json(['msg' => 'Successfully Updated Token..!!!']);
        }
    }

    // public function getLeads()
    // {

    //     $token = Token::first();
    //     // dd($token);
    //     $access_token = $token->access_token;
    //     // dd($token->access_token);
    //     $client = new Client();
    //     $response = $client->request('GET', 'https://api.rd.services/platform/segmentations', [
    //         'headers' => [
    //             'accept' => 'application/json',
    //             'authorization' => 'Bearer ' . $access_token,
    //         ],
    //     ]);
    //     // echo $response->getBody();
    //     $result = json_decode($response->getBody(), true);
    //     $segmentationNames = array_column($result['segmentations'], 'name');
    //     $segmentationId = null;
    //     $loan  = Loan::leftjoin('status','status.value','=','loans.status')
    //     ->select('status.name as StatusName')->get()->pluck('StatusName');
    //     // dd($loan);
    //     foreach ($loan as $desiredSegmentationName) {
    //         foreach ($result['segmentations'] as $segmentation) {
    //             if ($segmentation['name'] === $desiredSegmentationName) {
    //                 $segmentationId = $segmentation['id'];
    //                 // dd($segmentationId);
    //                 break;
    //             }
    //         }}

//         if ($segmentationId !== null) {
//             $contactsResponse = $client->request('GET', 'https://api.rd.services/platform/segmentations/' . $segmentationId . '/contacts', [
//                 'headers' => [
//                     'accept' => 'application/json',
//                     'authorization' => 'Bearer ' . $access_token,
//                 ],
//             ]);

//             $contactsResult = json_decode($contactsResponse->getBody(), true);
// dd($contactsResult);
//             foreach ($contactsResult['contacts'] as $contact) {
//                 $leads = new Leads;
//                 $leads->uuid = $contact['uuid'];
//                 $leads->name = $contact['name'];
//                 $leads->email = $contact['email'];
//                 $leads->loan_amount = '-';
//                 $leads->installments = '-';
//                 $leads->loan_status = '-';
//                 $leads->agent_id = '-';
//                 $leads->status = '-';
//                 $leads->created_at = $contact['created_at'];
//                 $leads->save();
//             }
//             return response()->json(['data' => $contactsResult]);

    // } else {
    //     echo "Segmentation with name '$desiredSegmentationName' not found." . PHP_EOL;
    // }
    // }
    public function post_leads(Loan $loan)
    {
        // dd("sdfgg");
        // dd($loan);
        // $loan->status = 1;
        // $loan->user_id = 2;
        $user = User::where('id', $loan->user_id)->first();
        //    dd($user);
        $status = Status::where('value', $loan->status)->first();
        if ($user && $user->uuid == null) {
            // dd($status);
            $token = Token::first();
            // dd($token);
            $access_token = $token->access_token;
            $postData = [];
            $postData = [
                'name' => $user->name,
                'email' => $user->email,
                'personal_phone' => $user->phone,
                'mobile_phone' => $user->phone,
                'tags' => [strtolower($status->name)],
                // 'tags' => ['pending'],
            ];
            // dd($postData);
            $body = json_encode($postData);
            // dd($body);
            $client = new Client();
            $response = $client->request('POST', 'https://api.rd.services/platform/contacts', [
                'body' => $body,
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Bearer ' . $access_token,
                    'content-type' => 'application/json',
                ],
            ]);
            // dd("dfgdfgdfgfdg");
            $result = $response->getBody();
            // dd($result);
            $result = json_decode($result, true);
            $user = User::where('email', $result['email'])->first();
            $user->uuid = $result['uuid'];
            $user->update();
            // dd($user);

            return ['status' => true, 'message' => 'Success'];
            // }
            // return ['status' => true, 'message' => 'User Already Saved'];
            // }
            //     return ['status' => false, 'message' => 'User not found!'];
        }
            // }
              // public function update_leads()
             // {
        else {
            // dd("fdgfg");
            $user = User::where('id',$loan->user_id)->select('uuid')->first();
            // dd($user);
            $status = Status::where('value', $loan->status)->first();
            // dd($status);
            $token = Token::first();
            $access_token = $token->access_token;
            $client = new Client();
            // $loans = Loan::leftJoin('users', 'users.id', '=', 'loans.user_id')
            //     ->leftJoin('status', 'status.value', '=', 'loans.status')
            //     ->select('loans.*', 'users.*', 'status.name as status')->get();
            $updateData = [];

            // foreach ($loans as $loan) {
                $identifier = 'uuid';
                $updateData = [
                    'name' => $loan->name,
                    'personal_phone' => $loan->phone,
                    'mobile_phone' => $loan->phone,
                    'tags' => [strtolower($status->name)],
                ];
            // }
            // dd($updateData);
            $body = json_encode($updateData);
            // dd($body);
            $response = $client->request('PATCH', "https://api.rd.services/platform/contacts/{$identifier}:{$user->uuid}", [
                'body' => $body,
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Bearer ' . $access_token,
                    'content-type' => 'application/json',
                ],
            ]);
            echo $response->getBody();
        }

    }

}
