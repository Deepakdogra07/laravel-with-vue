<?php

namespace App\Http\Controllers;

use App\Models\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhatsappController extends Controller
{
    public function index()
{
    $whatsapp = Whatsapp::where('id', 1)->first() ?? '';
    $whatsappNumber = $whatsapp->whatsapp ?? '';
    return inertia('Whatsapp/index', ['whatsappNumber' => $whatsappNumber]);
}

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'whatsapp' => ['required', 'numeric', 'digits:11', 'gt:0']
        ], [
            'whatsapp.required' => 'This field is required.',
            'whatsapp.numeric' => 'The WhatsApp number must be numeric.',
            'whatsapp.digits' => 'The WhatsApp number must be 11 digits long.',
            'whatsapp.gt' => 'WhatsApp number must be greater than 0.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        WhatsApp::updateOrCreate(
            ['id' => 1],
            ['whatsapp' => $request->whatsapp]
        );
    }

    public function getWhatsapp()
    {
        $whatsapp = Whatsapp::where('id', 1)->first() ?? '';
        $whatsappNumber = $whatsapp->whatsapp ?? '';
        return response()->json(['whatsappNumber' => $whatsappNumber]);
    }
}
