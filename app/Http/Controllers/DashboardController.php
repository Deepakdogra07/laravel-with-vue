<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardData(){
        $user = Auth::user();
        $users = User::all();    
        return Inertia::render('Dashboard', [ 'authData'=>$user,'users'=>$users]);
    }

}
