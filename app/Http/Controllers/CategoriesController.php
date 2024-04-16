<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriesController extends Controller
{
   public function index(){
    // return inertia('Admin/create');
    return Inertia::render('Admin/Categories/Index');
   }
   public function create(){
    return Inertia::render('Admin/Categories/Create');
   }
   public function store(Request $request){
    dd($request->all());
   }
   public function edit($id){
    
   }
   public function update(Request $request){
    
   }
   public function delete($id){
    
   }
}
