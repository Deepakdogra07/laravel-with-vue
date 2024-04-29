<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\Position;
use App\Models\Skills;
use App\Models\Industries;
use App\Models\Discipline;
use App\Models\Seniorities;
use App\Models\Workexperience;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobsController extends Controller
{
   public function index(){
        $jobs = Jobs::all();
        return Inertia::render('Admin/Jobs/Index',compact('jobs'));
   }
   public function create(){
    return Inertia::render('Admin/Jobs/Create');
   }
   public function store(){
    
   }
   public function edit($id){
    
   }
   public function update($id,Request $request){
    
   }
   public function destroy($id){
    
   }
}
