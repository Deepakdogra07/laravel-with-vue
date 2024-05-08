<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardData(){
        $user = Auth::user();
        $users = User::all();    
        $customers = User::where('user_type',3)->count();    
        $business = User::where('user_type',2)->count();    
        $jobs = Jobs::count();    
        return Inertia::render('Dashboard', [ 'authData'=>$user,'users'=>$users,'customers'=>$customers ,'business'=>$business,'jobs'=>$jobs]);
    }

}
