<?php

namespace App\Http\Controllers;

use App\Models\FooterData;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rules\MaxWords;

class FooterDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $links = FooterData::pluck('id')->first();
        if(!$links){
            return redirect()->route('update-links.create');
        }
        if($request->message){
            return redirect()->route('update-links.edit',[$links, 'message' => $request->message]);
        }
       return redirect()->route('update-links.edit',$links);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Footerdata/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'logo_image' => 'required|image',
            'logo_description' => ['required',new MaxWords(100)],
            'facebook_url' => 'required',
            'instagram_url' => 'required',
            'linkedin_url' => 'required',
            'twitter_url' => 'required',
            'office_phone' => 'required',
            'office_email' => 'required',
            'office_address' => 'required',
            'certificate_images.*' => 'required|image',
            'certificate_images' => 'max:4',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $data = new FooterData();
        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('logos/'.$name, file_get_contents($image));
            $data->logo_image = $name;
        }
        $data->logo_description = $request->logo_description;
        $data->facebook_url = $request->facebook_url;
        $data->instagram_url = $request->instagram_url;
        $data->linkedin_url = $request->linkedin_url;
        $data->twitter_url = $request->twitter_url;
        $data->office_phone = $request->office_phone;
        $data->office_email = $request->office_email;
        $data->office_address = $request->office_address;
        // $data->certificate_images = max:4,
        if ($request->hasFile('certificate_images')) {
            $certificates = [];
            foreach ($request->file('certificate_images') as $key => $img) {
                $image = $img;
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('certificates/'.$name, file_get_contents($image));
                $certificates[$key]=$name; 
            }
            $data->certificate_images = json_encode($certificates);
        }
        $data->save();
        return to_route('update-links.index',['status'=>true , 'message' => 'Data Added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(FooterData $footerData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {   
        $message = $request->message ?? null;
        $link = FooterData::where('id',$id)->first();
        return Inertia::render('Admin/Footerdata/Edit',compact("link", "message"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'logo_image' => 'required',
            'logo_description' => ['required',new MaxWords(100)],
            'facebook_url' => 'required',
            'instagram_url' => 'required',
            'linkedin_url' => 'required',
            'twitter_url' => 'required',
            'office_phone' => 'required',
            'office_email' => 'required',
            'office_address' => 'required',
            'certificate_images.*' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $data = FooterData::findorFail($request->id);
        if ($request->hasFile('logo_image')) {
            if (public_path($data->logo_image)) {
                $imagePath = substr($data->logo_image, strlen('/storage'));
                Storage::disk('public')->delete($imagePath);
             }
            $image = $request->file('logo_image');
            $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
            Storage::disk('public')->put('logos/'.$name, file_get_contents($image));
            $data->logo_image =  '/storage/logos/'. $name;
        }
        $data->logo_description = $request->logo_description;
        $data->facebook_url = $request->facebook_url;
        $data->instagram_url = $request->instagram_url;
        $data->linkedin_url = $request->linkedin_url;
        $data->twitter_url = $request->twitter_url;
        $data->office_phone = $request->office_phone;
        $data->office_email = $request->office_email;
        $data->office_address = $request->office_address;
        if ($request->hasFile('certificate_images') && ($request->certificate_images_status == true)) {
            $certificates = [];
            foreach ($request->file('certificate_images') as $key => $img) {
                $image = $img;
                $name = uniqid().'_'.time().'_'.'.'.$image->getClientOriginalExtension();
                Storage::disk('public')->put('certificates/'.$name, file_get_contents($image));
                $certificates[$key]= '/storage/certificates/' .$name; 
            }
            $data->certificate_images = json_encode($certificates);
        }
        $data->update();
        return to_route('update-links.index',['status'=>true , 'message' => 'Data Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data =FooterData::findOrFail($id);
        $data->forceDelete();
        return to_route('update-links.index',['status'=>true , 'message' => 'Data Deleted successfully!']);
    }
}
