<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyDataEntry extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\FooterData::insert([
            'logo_image' =>'/images/web-logo.png',
            'logo_description' =>'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.',
            'facebook_url' =>'https://www.facebook.com/',
            'instagram_url' =>'https://www.instagram.com/',
            'linkedin_url' =>'https://www.linkedin.com/',
            'twitter_url' =>'https://www.twitter.com/',
            'office_phone' =>'9876543210',
            'office_email' =>'test@yopmail.com',
            'office_address' =>'Vision Vivante Pvt Ltd',
            'certificate_images' =>json_encode(['/images/MembershipLogo.png','/images/NewZealandLic.png']),
        ]);


        \App\Models\Logo::insert([
            'logo_heading' =>'Logo Heading',
            'logo_description' =>'Lorem ipsum is placeholder text commonly used in the graphic and visual mockups.',
            'country_description' =>'Countries Listed Here',
            'country_1_name' =>'Australia',
            'country_2_name' =>'New Zealand',
            'video_heading' =>'This is video Heading',
            'video_subheading' =>'This is video SubHeading',
            'video_description' =>'Lorem ipsum is placeholder text commonly used in the graphic and visual mockups.',
            'category_heading' =>'Category Heading',
            'category_subheading' =>'Category SubHeading',
            'logo_image' =>'/images/unstoppable-bw.png',
            'country_1_image' =>'/images/australia.jpg',
            'country_2_image' =>'/images/new-zealand.jpg',
            'video_introduction' =>'/images/new-video.mp4',
        ]);
        \App\Models\Slider::insert([
            'slider_heading' =>'Slider Heading',
            'slider_description' =>'Lorem ipsum is placeholder text commonly used in the graphic and visual mockups.',
            'slider_image' =>'/images/web-banner.png',
       ]);
       \App\Models\Category::insert([
        'category_heading' =>'Category Heading',
        'thumbnail' =>'/images/profile1.jpg',
        'category_image' =>'/images/web-banner.png',
        'status'=>1
    ]);


    }
}
