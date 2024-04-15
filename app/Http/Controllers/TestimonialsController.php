<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonialRecords =    Testimonial::all();
        return Inertia::render('Testimonial/index',['testimonialRecords'=>$testimonialRecords]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Testimonial/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            // 'rating' => 'required|numeric|gt:0|lt:6',
            'content' => 'required',
        ],[
            'name.required' => 'Title is must.',
            'rating.required' => 'Link is must.',
            'content.required' => 'Content is must.',
        ]);

            if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }

            Testimonial::create([
                'name'=>$request->name ?? "",
                // 'rating'=>$request->rating ?? "",
                'content'=>$request->content ?? "",
            ]);

            return to_route('testimonial.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editTestimonial = Testimonial::where('id',$id)->first();
        return Inertia::render('Testimonial/edit',['editTestimonial'=>$editTestimonial]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            // 'rating' => 'required|numeric|gt:0|lt:6',
            'content' => 'required',
        ],[
            'name.required' => 'Title is must.',
            'rating.required' => 'Link is must.',
            'content.required' => 'Content is must.',
        ]);

            if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }

           $testimonialUpdate = Testimonial::find($id);
           if($testimonialUpdate){
                $testimonialUpdate->name = $request->name;
                $testimonialUpdate->content = $request->content;
                $testimonialUpdate->update();
           }

           return to_route('testimonial.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Testimonial::where('id',$id)->delete();
        return to_route('testimonial.index');
    }
}
