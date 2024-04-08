<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Leads;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate()
        ]);
    }
    public function assignAgent()
    {
      $users = User::where('user_type','2')->where('is_deleted',0)->get();
      return response()->json($users);
    }
    public function assignAgentSave(Request $request, $id, $leadId)
    {
        // dd($id);
        // dd($leadId);
        $user = Loan::where('id',$leadId)->update([
                'assigned_to' => $request->id,
            ]);
            // dd($user);
    }
}
