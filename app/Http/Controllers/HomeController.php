<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\News;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $allLoanRecordThisUser = Loan::where('user_id', Auth::user()->id)->get();
            $discountcodeOfSuperAdmin = User::where('user_type', 1)->first()?->referralcode;

            $matchedLoanRecords = $allLoanRecordThisUser->filter(function ($loan) use ($discountcodeOfSuperAdmin) {
                return $loan->discount_code === $discountcodeOfSuperAdmin;
            });


            if ($matchedLoanRecords->isEmpty()) {
                $discountCode = $request->query('discountcode');

                if($discountCode){
                    Session::put('discountcode', $discountCode);
                }
            }
        }elseif(!Auth::user() && $request->query('discountcode')){
            $discountCode = $request->query('discountcode');
            Session::put('discountcode', $discountCode);
        }


        // dd('Anand');

        // $discountCode = Session::get('discountcode');
        // dd($discountCode);







         if(Auth::user()){
            $myRecord = Auth::user()->referralcode;
         }



        if (Auth::check() && $myRecord != $request->query('refralcode')) {
            $allLoanofUser = Loan::where('user_id', Auth::user()->id)->get();


            $hasReferralLink = $allLoanofUser->contains(function ($loan) {
                return $loan->referralLink !== null;
            });

            if($hasReferralLink == false){
                $refralcode = $request->query('refralcode');

                if ($refralcode) {
                    Session::put('refralcode', $refralcode);
                }
            }
            // else{
            //     $refralcode = $request->query('refralcode');

            //     if ($refralcode) {
            //         Session::put('refralcode', $refralcode);
            //     }
            // }
        }elseif(!Auth::user() && $request->query('refralcode')){
                $refralcode = $request->query('refralcode');

                if ($refralcode) {
                    Session::put('refralcode', $refralcode);
                }
        }














        // $refralcode = $request->query('refralcode');
        // if ($refralcode) {
        //     Session::put('refralcode', $refralcode);
        // }




        // $discountCode = $request->query('discountcode');

        // if($discountCode){
        //     Session::put('discountcode', $discountCode);
        // }









        $allNews = News::take(16)->get();
        $testimonials = Testimonial::take(8)->get();
        $countTestimonials = count($testimonials);
        $countallNews = count($allNews);
        return Inertia::render('Welcome',['allNews' => $allNews , 'testimonials'=>$testimonials,
         'countTestimonials'=>$countTestimonials,
         'countallNews' => $countallNews,
    ]);

        // return Inertia::render('Frontend/Loan/view', ['userRecord' => $userRecord]);
    }

    public function mobile_index(Request $request)
    {
        if($request->device == 'mobile'){
            $allNews = News::take(8)->get();
            $testimonials = Testimonial::take(4)->get();
        }
        if($request->device == 'desktop'){
            $allNews = News::take(16)->get();
            $testimonials = Testimonial::take(8)->get();
        }

        $data = [
            'news' => $allNews,
            'testimonials' => $testimonials,
        ];
        return response()->json($data);
    }
}
