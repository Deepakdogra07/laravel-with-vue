<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditHomePageController;
use App\Http\Controllers\FooterDataController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\TestimonialsController;
    
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
});
// Route::get('/about', fn() => Inertia::render('About'))->name('about');
Route::middleware(['admin', 'auth', 'check_user_status'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('Admin');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('testimonial', TestimonialsController::class);
    Route::post('testimonial/updated/{id}', [TestimonialsController::class, 'update'])->name('testimonial.updated');

    // GET EMPLOYERS LISTING 
    Route::get('/business-listing', [AgentController::class, 'index'])->name('business-listing');

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
    // Route::get('/pages/view/{id}', [PagesController::class, 'viewPages'])->name('pages.view-pages');
    // Route::get('/pages/edit/{id}', [PagesController::class, 'editPages'])->name('pages.edit-pages');
    // Route::put('/pages/update/{id}', [PagesController::class, 'updatePages'])->name('pages.update-pages');
    // Route::get('/pages/delete/{id}', [PagesController::class, 'deletePages'])->name('pages.delete-pages');


    // Route::get('/pages/details', [PagesController::class, 'details'])->name('pages.add-details');
    // Route::post('/pages/details', [PagesController::class, 'detailSave'])->name('pages.details-save');


});

Route::get('/job-listing', [JobsController::class,'job_listing'])->name("job.listing");

Route::get('/view-job/{id}',[JobsController::class,'view_job'] )->name("view.job");


Route::get('/dashboard', [DashboardController::class, 'dashboardData'])
    ->middleware(['auth','user.type'])
    ->name('dashboard');

Route::get('/faq', function () {
    return Inertia::render('Frontend/Faqs/index');
})->name('faq');

Route::get('/testimonials',[TestimonialsController::class,"show_testimonials"])->name('testimonial.main');

require __DIR__ . '/auth.php';

Route::get('/layouts', function () {
    return inertia('Frontend/Layouts/sidebar');
});

Route::get('/about-us', function () {
    return Inertia('About/AboutUs');
})->name('about.us');

Route::get('/contact-us', function () {
    return inertia('Frontend/Contactus/ContactUs');
})->name('contact.us');

Route::get('/job-application', function () {
    return inertia('JobForm/JobApplication');
})->name('job.application');
