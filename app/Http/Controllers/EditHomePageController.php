<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;


class EditHomePageController extends Controller
{
    public function index(){
        $sliders = Slider::get();
        return Inertia::render('Admin/index',compact("sliders"));
    }

    public function create(){
        return Inertia::render('Admin/create');
    }
    public function store(Request $request){
        // dd($request->sliderImage);
        $slider = new Slider();
        if ($request->hasFile('sliderImage')) {
            $image = $request->file('sliderImage');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('slider/'.$name, file_get_contents($image));
            $slider->slider_image = $name;
        }
        $slider->slider_name = $request->sliderName;
        $slider->slider_heading = $request->sliderHeading;
        $slider->slider_description = $request->sliderDescription;
        $slider->save();

        return redirect()->route('edit-home-page')->with(['status'=>true , 'msg'=>'Data Added successfully']);
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
        return redirect()->route('edit-home-page')->with(['status'=>true , 'msg'=>'Data Updated successfully']);
    }
    public function delete($id){
        $slider = Slider::findOrFail($id);
        $slider->forceDelete();
    }
}
