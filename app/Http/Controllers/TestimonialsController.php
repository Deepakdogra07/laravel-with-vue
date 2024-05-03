<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'required',
            'content' => 'required',
            'description' =>"required",
        ],[
            'name.required' => 'Name is must.',
            'image.required' => 'Image is must.',
            'content.required' => 'Content is must.',
        ]);
        
        if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
        }
        
            $testimonial = new Testimonial();
            $testimonial->name = $request->name;
            $testimonial->content = $request->content;
            $testimonial->description = $request->description;
            $testimonial->status = ($request->status =="1") ? 1 :0;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('testimonials/'.$name, file_get_contents($image));
                $testimonial->image_link = '/storage/testimonials/'.$name;
            }
            if ($request->hasFile('video')) {
                $image = $request->file('video');
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('testimonials/'.$name, file_get_contents($image));
                $testimonial->video_link = '/storage/testimonials/'.$name;
            }
            $testimonial->save();

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
            'content' => 'required',
        ],[
            'name.required' => 'Name is must.',
            'content.required' => 'Content is must.',
        ]);
            if($validate->fails()){
            return back()->withErrors($validate->errors())->withInput();
            }

           $testimonialUpdate = Testimonial::find($id);
           if($testimonialUpdate){
                $testimonialUpdate->name = $request->name;
                $testimonialUpdate->content = $request->content;
                $testimonialUpdate->status = ($request->status =="1") ? 1 :0;
            if ($request->hasFile('image') && $testimonialUpdate->image_link != $request->image ) {
                if (public_path($testimonialUpdate->image_link)) {
                    $imagePath = substr($testimonialUpdate->image_link, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                 }
                $image = $request->file('image');
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('testimonials/'.$name, file_get_contents($image));
                $testimonialUpdate->image_link = '/storage/testimonials/'.$name;
                }
            if ($request->hasFile('video')) {
                if (public_path($testimonialUpdate->video_link)) {
                    $imagePath = substr($testimonialUpdate->video_link, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                 }
                $image = $request->file('video');
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('testimonials/'.$name, file_get_contents($image));
                $testimonialUpdate->video_link = '/storage/testimonials/'.$name;;
            }
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
    public function show_testimonials(){
        $testimonials = Testimonial::where('status',1)->get();
        return Inertia::render('Testimonial/alltestimonials',compact('testimonials'));
    }
}
