<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Logo;
use Illuminate\Support\Facades\Storage;
use App\Rules\MaxWords;



class EditHomePageController extends Controller
{
    public function index(Request $request){
        $sliders = Slider::get();
        if($request->has('status')){
            $msg = $request->has('message') ? $request->message : null;
        return Inertia::render('Admin/Slider/index',compact("sliders","msg"));
        }
        return Inertia::render('Admin/Slider/index',compact("sliders"));
    }

    public function create(){
        return Inertia::render('Admin/Slider/create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'slider_image' => 'required|image',
            'slider_heading' => 'required',
            'slider_description' => ['required',new MaxWords(100)],
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
            $slider->slider_image = '/storage/slider/' .$name;
        }
        $slider->slider_heading = $request->slider_heading;
        $slider->slider_description = $request->slider_description;
        $slider->save();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Added successfully!']);
    }
    public function edit($id){
        $slider = Slider::where('id',$id)->first();
        return Inertia::render('Admin/Slider/edit',compact("slider"));
    }
    public function update(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'sliderHeading' => 'required',
            'sliderImage' =>  'required',
            'sliderDescription' =>['required',new MaxWords(100)],
        ]);
        // dd($validator->errors());
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $slider = Slider::findOrFail($request->id);

        if ($request->hasFile('sliderImage') && ($slider->slider_image != $request->sliderImage)) {
            if (public_path($slider->slider_image)) {
                $imagePath = substr($slider->slider_image, strlen('/storage'));
                Storage::disk('public')->delete($imagePath);
             }
            $image = $request->file('sliderImage');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('slider/'.$name, file_get_contents($image));
            $slider->slider_image = '/storage/slider/' .$name;
        }
        $slider->slider_heading = $request->sliderHeading;
        $slider->slider_description = $request->sliderDescription;
        $slider->update();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Updated successfully!']);
    }
    public function show($id){
        $slider = Slider::findOrFail($id);
        return Inertia::render('Admin/Slider/show',compact("slider"));
    }
    public function delete($id){
        $slider = Slider::findOrFail($id);
        $slider->forceDelete();
        return to_route('edit-home-page',['status'=>true , 'message' => 'Data Deleted successfully!']);
    }

    public function logo_index(Request $request){
        $logos = Logo::all();
        if($request->has('status')){
            $msg = $request->has('message') ? $request->message : null;
        return Inertia::render('Admin/Logo/Index',compact("logos","msg"));
        }
        return Inertia::render('Admin/Logo/Index',compact("logos"));
    }
    public function logo_create(){
        return Inertia::render('Admin/Logo/Create');
    }
    public function logo_store(Request $request){
        $validator = Validator::make($request->all(),[
            'image_image' => 'required|image',
            'image_heading' => 'required',
            'image_description' =>['required',new MaxWords(100)],
            'country_1_name' => 'required',
            'country_1_image' => 'required|image',
            'country_2_name' => 'required',
            'country_2_image' => 'required|image',
            'video_heading' => 'required',
            'video_subheading' => 'required',
            'video_description' => 'required',
            'video' => 'required|file|mimes:mp4|max:50000',
            'country_description'=>'required',
            'category_heading'=>'required',
            'category_subheading'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $logo = new Logo();
        $logo->logo_heading = $request->image_heading;
        $logo->logo_description = $request->image_description;
        if ($request->hasFile('image_image')) {
            
            $image = $request->file('image_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
            $logo->logo_image = $name;
        }
        if ($request->hasFile('video')) {
            $image = $request->file('video');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('videos/'.$name, file_get_contents($image));
            $logo->video_introduction = $name;
        }
        if ($request->hasFile('country_1_image')) {
            $image = $request->file('country_1_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
            $logo->country_1_image = $name;
        }
        $logo->country_description = $request->country_description;
        $logo->category_heading = $request->category_heading;
        $logo->category_subheading = $request->category_subheading;
        $logo->country_1_name = $request->country_1_name;
        $logo->country_2_name = $request->country_2_name;
        $logo->video_heading = $request->video_heading;
        $logo->video_subheading = $request->video_subheading;
        $logo->video_description = $request->video_description;
        if ($request->hasFile('country_2_image')) {
            $image = $request->file('country_2_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
            $logo->country_2_image = $name;
        }
        $logo->save();
        return to_route('edit-logo',['status'=>true , 'message' => 'Data Updated successfully!']);
    }
    public function logo_edit($id){
        $logo = Logo::where('id',$id)->first();
        return Inertia::render('Admin/Logo/Edit',["logo"=>$logo]);
    }
    public function logo_update(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'image_heading' => 'required',
            'image_description' => ['required',new MaxWords(100)],
            'country_1_name' => 'required',
            'country_2_name' => 'required',
            'video_heading' => 'required',
            'video_subheading' => 'required',
            'video_description' => 'required',
            'country_description'=>'required',
            'category_heading'=>'required',
            'category_subheading'=>'required|string|max:1000',

        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        try{
            $logo = Logo::findOrFail($request->id);
            $logo->logo_heading = $request->image_heading;
            $logo->logo_description = $request->image_description;
            if($logo->logo_image != $request->image_image){
                if (public_path($logo->logo_image)) {
                    $imagePath = substr($logo->logo_image, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                 }
                if ($request->hasFile('image_image')) {
                    $image = $request->file('image_image');
                    $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                    Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
                    $logo->logo_image = '/storage/logo/'. $name;
            }
            }
            if($logo->video_introduction != $request->video){
                if (public_path($logo->video_introduction)) {
                    $imagePath = substr($logo->video_introduction, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                 }
                    if ($request->hasFile('video')) {
                        $image = $request->file('video');
                        $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                        Storage::disk('public')->put('videos/'.$name, file_get_contents($image));
                        $logo->video_introduction ='/storage/videos/'. $name;
                    }
                }
            if($logo->country_1_image != $request->country_1_image){
                if (public_path($logo->country_1_image)) {
                    $imagePath = substr($logo->country_1_image, strlen('/storage'));
                    Storage::disk('public')->delete($imagePath);
                 }
                if ($request->hasFile('country_1_image')) {
                    $image = $request->file('country_1_image');
                    $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                    Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
                    $logo->country_1_image = '/storage/logo/'.$name;
                }
            }
            $logo->country_description = $request->country_description;
            $logo->category_heading = $request->category_heading;
            $logo->category_subheading = $request->category_subheading;
            $logo->country_1_name = $request->country_1_name;
            $logo->country_2_name = $request->country_2_name;
            $logo->video_heading = $request->video_heading;
            $logo->video_subheading = $request->video_subheading;
            $logo->video_description = $request->video_description;
            if($logo->country_2_image != $request->country_2_image){
                if ($request->hasFile('country_2_image')) {
                    if (public_path($logo->country_2_image)) {
                        $imagePath = substr($logo->country_2_image, strlen('/storage'));
                        Storage::disk('public')->delete($imagePath);
                     }
                    $image = $request->file('country_2_image');
                    $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                    Storage::disk('public')->put('logo/'.$name, file_get_contents($image));
                    $logo->country_2_image = '/storage/logo/'. $name;
                }
            }
            $logo->update();
        }catch(\Exception $e){
            return back()->withErrors($e->getMessage());
        }
        $logo = Logo::where('id',$request->id)->first();
        return to_route('edit-logo.edit', ['id' => $logo->id])
        ->with(['status' => true, 'message' => 'Data Updated successfully!']);
    }
    public function logo_delete($id){
        $logo = Logo::findOrFail($id);
        $logo->forceDelete();
        return to_route('edit-logo',['status'=>true , 'message' => 'Data Deleted successfully!']);
    }
    public function other_data(){
        $logos = Logo::pluck('id')->first();
        if(!$logos){
            return redirect()->route('edit-logo.create');
        }
        return redirect()->route('edit-logo.edit', ['id' => $logos]);
    }
}
