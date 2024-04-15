<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;


class EditHomePageController extends Controller
{
    public function index(Request $request){
        $sliders = Slider::get();
        if($request->has('status')){
            $msg = $request->has('message') ? $request->message : null;
        return Inertia::render('Admin/index',compact("sliders","msg"));
        }
        return Inertia::render('Admin/index',compact("sliders"));
    }

    public function create(){
        return Inertia::render('Admin/create');
    }
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'slider_image' => 'required|image',
            'slider_name' => 'required',
            'slider_heading' => 'required',
            'slider_description' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $count = Slider::all()->count();
        if($count >=5){
            return back()->withErrors(['message'=> "You can only add upto 5 sliders."]);
        }

        $slider = new Slider();
        if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('slider/'.$name, file_get_contents($image));
            $slider->slider_image = $name;
        }
        $slider->slider_name = $request->slider_name;
        $slider->slider_heading = $request->slider_heading;
        $slider->slider_description = $request->slider_description;
        $slider->save();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Added successfully!']);
        // return Inertia::location(route('edit-home-page'))->with(['status', 'message' => 'Data added successfully']);
    }
    public function edit($id){
        $slider = Slider::where('id',$id)->first();
        return Inertia::render('Admin/edit',compact("slider"));
    }
    public function update(Request $request){
        $slider = Slider::findOrFail($request->id);

        if ($request->hasFile('sliderImage') && ($slider->slider_image != $request->sliderImage)) {
            $image = $request->file('sliderImage');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('slider/'.$name, file_get_contents($image));
            $slider->slider_image = $name;
        }
        $slider->slider_name = $request->sliderName;
        $slider->slider_heading = $request->sliderHeading;
        $slider->slider_description = $request->sliderDescription;
        $slider->update();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Updated successfully!']);
    }
    public function show($id){
        $slider = Slider::findOrFail($id);
        return Inertia::render('Admin/show',compact("slider"));
    }
    public function delete($id){
        $slider = Slider::findOrFail($id);
        $slider->forceDelete();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Deleted successfully!']);
    }
}
