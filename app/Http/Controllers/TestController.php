<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        // dd('here');
        $data = Jobs::with('currencies','skills')->get();
        dd($data);
    }
}
