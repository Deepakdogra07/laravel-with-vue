<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\Logo;
use App\Models\FooterData;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::all();
        $logo = Logo::first();
        $categories = Category::where('status',1)->get();
        $footer_data = FooterData::first();
        if(!$footer_data){
            return redirect()->route('login');
        }
        return Inertia::render('Welcome',compact('sliders',"logo","categories","footer_data"));
    }
    public function business_dash(){
        $footer_data = FooterData::first();
        return Inertia::render('Business/Welcome',compact('footer_data'));
    }

    public function customer_dash(){
        $footer_data = FooterData::first();
        return Inertia::render('Customer/Welcome',compact('footer_data'));
    }
    
}
