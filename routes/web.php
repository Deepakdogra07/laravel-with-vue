<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FooterDataController;
use App\Http\Controllers\EditHomePageController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\JobApplicationController;
    
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can ister web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/privacy-policy', function () {
    return Inertia::render('Frontend/PrivacyPolicy/privacy-policy');
})->name('privacy.policy');

Route::get('/contactus', [ContactusController::class, 'index'])->name('contactus.listing');
Route::get('/contactus-view/{id}', [ContactusController::class, 'view'])->name('contactus.view');
Route::post('/contactus', [ContactusController::class, 'store'])->name('contact_us.store');




Route::get('/term-condition', function () {
    return Inertia::render('Frontend/PrivacyPolicy/term-condition');
})->name('term.condition');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('footer-data', [FooterDataController::class, 'index'])->name('footer.data.get');
Route::middleware(['auth','check_user_status'])->group(function () {
    Route::get('/business-dash', [HomeController::class, 'business_dash'])->name('business-dash');
    Route::get('/customer-dash', [HomeController::class, 'customer_dash'])->name('customer-dash');
});
// Route::get('/about', fn() => Inertia::render('About'))->name('about');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::put('/profile-business', [ProfileController::class, 'update_business'])->name('update.business');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');





Route::middleware(['admin:1', 'auth', 'check_user_status'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('Admin');
    });

    Route::resource('testimonial', TestimonialsController::class);
    Route::post('testimonial/updated/{id}', [TestimonialsController::class, 'update'])->name('testimonial.updated');

    // GET EMPLOYERS LISTING 
    Route::resource('/business-listing', AgentController::class);
    Route::post('/business-listing/updates', [AgentController::class,'update'])->name("business-listing.updates");

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/add-customer', [CustomerController::class, 'show'])->name('customers.add-customer');
    Route::post('/customers/add-customer', [CustomerController::class, 'add']);
    Route::get('/customers/view-customer/{id}', [CustomerController::class, 'view'])->name('customers.view-customer');
    Route::get('/customers/edit-customer/{id}', [CustomerController::class, 'edit'])->name('customers.edit-customer');
    Route::put('/customers/update-customer/{id}', [CustomerController::class, 'update'])->name('customers.update-customer');
    Route::get('/customers/delete-customer/{id}', [CustomerController::class, 'delete'])->name('customers.delete-customer');
    
    
    Route::get('/edit-home-page', [EditHomePageController::class, 'index'])->name('edit-home-page');
    Route::get('/home-page/create', [EditHomePageController::class, 'create'])->name('home-page.create');
    Route::post('/home-page/store', [EditHomePageController::class, 'store'])->name('home-page.store');
    Route::get('/home-page/delete/{id}', [EditHomePageController::class, 'delete'])->name('home-page.delete');
    Route::get('/home-page/edit/{id}', [EditHomePageController::class, 'edit'])->name('home-page.edit');
    Route::post('/home-page/update', [EditHomePageController::class, 'update'])->name('home-page.update');
    Route::get('/home-page/{id}', [EditHomePageController::class, 'show'])->name('home-page.show');

    // Route::get('/pages', [PagesController::class, 'pages'])->name('pages');
    Route::get('/other_data', [EditHomePageController::class, 'other_data'])->name('other_data');
    Route::get('/edit-logo', [EditHomePageController::class, 'logo_index'])->name('edit-logo');
    Route::get('/edit-logo/create', [EditHomePageController::class, 'logo_create'])->name('edit-logo.create');
    Route::post('/edit-logo/store', [EditHomePageController::class, 'logo_store'])->name('edit-logo.store');
    Route::get('/edit-logo/edit/{id}', [EditHomePageController::class, 'logo_edit'])->name('edit-logo.edit');
    Route::post('/edit-logo/update', [EditHomePageController::class, 'logo_update'])->name('edit-logo.update');
    Route::get('/edit-logo/delete/{id}', [EditHomePageController::class, 'logo_delete'])->name('edit-logo.delete');
    // Route::resource('/test-123',EditHomePageController::class);
    Route::resource('category',CategoriesController::class);
    Route::post('category/updated/{id}', [CategoriesController::class, 'update'])->name('category.updated');
    Route::post('/update-links/update',[FooterDataController::class,'update'])->name('update-link-update');
    Route::resource('update-links',FooterDataController::class);
    Route::resource('jobs',JobsController::class);
    Route::post('jobs/updates/{id}',[JobsController::class,'update'])->name('jobs.updates');
    Route::get('jobs-customers/{jobId}',[JobsController::class, 'job_for_customer'])->name('job_for_customers');
    
    Route::get('view_applied_customer/{customer_id}/{job_id}',[JobsController::class,'view_applied_customer'])->name('view_applied_customer');


});


Route::middleware(['auth', 'business'])->group(function () {
    Route::resource('business-jobs',BusinessController::class);
    Route::post('business-jobs/updates/{id}',[BusinessController::class,'update'])->name('business-jobs.updates');
    Route::get('business-jobs-customers/{jobId}',[BusinessController::class, 'job_for_customer'])->name('business_job_for_customers');
    Route::get('customer-filteration/{status}',[BusinessController::class,'customer_filteration'])->name('customer.filteration');
    Route::get('customer-search/{status}',[BusinessController::class,'customer_search'])->name('customer.search');
    Route::get('jobs-search/{status}',[BusinessController::class,'jobs_search'])->name('jobs.search');
    Route::post('change-status',[BusinessController::class,'change_status'])->name('change.status');
    Route::get('view_customer/{customer_id}',[BusinessController::class,'view_customer'])->name('view_customer');
    Route::get('applied-business-jobs',[BusinessController::class,'applied_business_jobs'])->name('applied-business-jobs');
    
});

// Customer

Route::get('create-business', [CustomerController::class,'createBusiness'])->name("create.business");
Route::post('register.customer', [CustomerController::class,'registerCustomer'])->name("register.customer");
Route::get('view-customer-data/{customer_id}',[CustomerController::class,'view_customer'])->name('view_customer_data');


Route::get('data-filteration/{job_id}/{status}',[JobsController::class,'data_filteration'])->name('data-filteration');

Route::get('/job-listing', [JobsController::class,'job_listing'])->name("job.listing");

Route::get('/view-job/{id}',[JobsController::class,'view_job'] )->name("view.job");






Route::get('/dashboard', [DashboardController::class, 'dashboardData'])
    ->middleware(['auth','user.type'])
    ->name('dashboard');

Route::get('/faq', function () {
    return Inertia::render('Frontend/Faqs/index');
})->name('faq');

Route::get('/testimonials',[TestimonialsController::class,"show_testimonials"])->name('testimonial.main');
Route::get('/show-testimonials/{testimonial_id}',[TestimonialsController::class,"show_detailed_testimonial"])->name('show.testimonial');

require __DIR__ . '/auth.php';

Route::get('/layouts', function () {
    return inertia('Frontend/Layouts/sidebar');
});

Route::get('/403', function () {
    return inertia('Frontend/ErrorPages/403');
})->name('403');
Route::get('/404', function () {
    return inertia('Frontend/ErrorPages/404');
})->name('404');
Route::get('/about-us', function () {
    return Inertia('About/AboutUs');
})->name('about.us');

Route::get('/contact-us', function () {
    return inertia('Frontend/Contactus/ContactUs');
})->name('contact.us');

Route::get('/job-application', function () {
    return inertia('JobForm/JobApplication');
})->name('job.application');


Route::get('/job-introduction/{job_id}/{customer_id}', [JobApplicationController::class , 'introduction'])->name('job.introduction');

Route::get('/travel-details/{job_id}',[JobApplicationController::class , 'travel_details'] )->name('travel.details');

Route::match(['get','post'],'/personal-details/{job_id}',[JobApplicationController::class , 'personal_details'])->name('personal.details');
Route::match(['get','post'],'/submit-personal-details/{job_id}',[JobApplicationController::class , 'submit_personal_details'] )->name('submit_personal_details');


Route::get('/employment-details/{job_id}/{customer_id}', [JobApplicationController::class,'employment_details'])->name('employment.details');
Route::post('/validate_employment_details', [JobApplicationController::class,'validate_emp_details'])->name('validate_employment_details');
Route::post('/submit_employment_details', [JobApplicationController::class,'submit_employment_details'])->name('submit_employment_details');

Route::get('/document-details/{job_id}/{customer_id}',[JobApplicationController::class,'document_details'])->name('document.details');
Route::post('/validate_customer_documents', [JobApplicationController::class,'validate_customer_documents'])->name('validate_customer_documents');
Route::post('/submit_customers_documents', [JobApplicationController::class,'submit_customers_documents'])->name('submit_customers_documents');


Route::get('testing',[TestController::class,'index']);