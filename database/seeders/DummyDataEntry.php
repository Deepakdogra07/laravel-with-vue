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
            'logo_description' =>'We are an Job search and immigration services firm specializing in the digital processing of job searches and related immigration services, Our aim is to fully digital the job search and immigration process in every country in the world, for individuals, families businesses, Let us be part of your individuals journey.',
            'facebook_url' =>'https://www.facebook.com/',
            'instagram_url' =>'https://www.instagram.com/',
            'linkedin_url' =>'https://www.linkedin.com/',
            'twitter_url' =>'https://www.twitter.com/',
            'office_phone' =>'+1300 779 462',
            'office_email' =>'Info@dizonassociates.com.au',
            'office_address' =>'Level 5 12 clarke St, Sunshine Victoria, Australia 3020 (enter via vicroads building',
            'certificate_images' =>json_encode(['/images/MembershipLogo.png','/images/NewZealandLic.png']),
        ]);


        \App\Models\Logo::insert([
            'logo_heading' =>'unstoppable',
            'logo_description' =>'CREATING BORDERLESS OPPORTUNITIES.',
            'country_description' =>'Most Interesting countries with job opportunities',
            'country_1_name' =>'Australia',
            'country_2_name' =>'New Zealand',
            'video_heading' =>'How does it work',
            'video_subheading' =>'Watch our video on how the journey is done in our app and get inspired',
            'video_description' =>'log your profile now and apply in your country of choise.',
            'category_heading' =>'Welcome to UNSTOPPABLE',
            'category_subheading' =>'We are an job search and immigration services firm specializing in the digital processing of job searches and related immigration services for skilled workers. Our aim is to fully digitize the job search and immigration process in every country in the world. for skilled workers. UNSTOPPABLE best describe the two founders but also the vision for the firm to make everything possible our clients aim for.',
            'logo_image' =>'/images/unstoppable-bw.png',
            'country_1_image' =>'/images/australia.jpg',
            'country_2_image' =>'/images/new-zealand.jpg',
            'video_introduction' =>'/images/new-video.mp4',
        ]);
        \App\Models\Slider::insert([
            'slider_heading' =>'We Are Unstoppable',
            'slider_description' =>'Specializing in borderless working opporuntiies for skilled worker accross the globe for individuals, families and business, we provide exceptional workflow solutions that sllows you to almost borderless immigrate from your home country to the country to the country you would like to live and work in.',
            'slider_image' =>'/images/web-banner.png',
       ]);
       \App\Models\Category::insert([
        'category_heading' =>'Hospitality worker',
        'thumbnail' =>'/images/profile1.jpg',
        'category_image' =>'/images/web-banner.png',
        'status'=>1
    ]);


    }
}
