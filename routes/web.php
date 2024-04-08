<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LoanManagement;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\WhatsappController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\Frontend\LoanController;
use App\Http\Controllers\Frontend\LoanCalculatorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::post('loan/view/details',[LoanController::class,'loanViewDetails']);



Route::get('/privacy-policy', function () {
    return Inertia::render('Frontend/PrivacyPolicy/privacy-policy');
})->name('privacy.policy');

Route::get('/contactus', [ContactusController::class, 'create'])->name('contactus');
Route::post('/contactus', [ContactusController::class, 'store']);

Route::get('/aboutus', function () {
    return Inertia::render('Frontend/About/aboutus');
})->name('about.us');



Route::get('/term-condition', function () {
    return Inertia::render('Frontend/PrivacyPolicy/term-condition');
})->name('term.condition');




Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/home-page',[HomeController::class,'mobile_index'])->name('home.mobile');

Route::get('/get-whatsapp',[WhatsappController::class,'getWhatsapp'])->name('get-whatsapp');

Route::middleware(['admin', 'auth','check_user_status'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('Admin');
    });


    Route::get('/whatsapp',[WhatsappController::class,'index'])->name('whatsapp');
    Route::post('/whatsapp/store',[WhatsappController::class,'store']);


     Route::post('/loan/store/backend/record',[LoanManagement::class,'loanStoreBackendRecord']);




      Route::resource('news', NewsController::class);
      Route::post('news/updated/{id}',[NewsController::class,'update'])->name('news.updated');



       Route::resource('testimonial', TestimonialsController::class);
       Route::post('testimonial/updated/{id}',[TestimonialsController::class,'update'])->name('testimonial.updated');



    Route::get('/about', fn() => Inertia::render('About'))->name('about');
    Route::get('/loan', [LoanManagement::class, 'index'])->name('loan.index');



    Route::get('/loan/create', [LoanManagement::class, 'create'])->name('loan.create');

    Route::post('loan/store', [LoanManagement::class, 'store'])->name('loan.store');


    Route::get('/loan/edit/{id}', [LoanManagement::class, 'edit'])->name('loan.edit');



    Route::get('/loan/view/page/{id}', [LoanManagement::class, 'loanViewPage'])->name('loan.view.page');




    Route::get('/loan/view/{id}', [LoanManagement::class, 'show'])->name('loan.view');
    Route::post('/loan/update/{id}', [LoanManagement::class, 'update'])->name('loan.update');
    Route::delete('/loan/delete/{id}', [LoanManagement::class, 'delete'])->name('loan.delete');
    Route::get('/loan/deleted', [LoanManagement::class, 'deletedLoan'])->name('deleted.loans');
    Route::delete('/loan/deleted/{id}', [LoanManagement::class, 'deletePermanent'])->name('loan.delete_p');
    Route::get('/loan/assigned', [LoanManagement::class, 'getAssignedLoan'])->name('loan.assignedloan');

    Route::post('/changeLoanStatus/{loanId}', [LoanManagement::class, 'changeStatus'])->name('lona.status');
    Route::get('/approved/loans', [LoanManagement::class, 'approved'])->name('loans-approved');
    Route::get('/rejected/loans', [LoanManagement::class, 'rejectedList'])->name('loans.rejected');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('/assignAgent', [UserController::class, 'assignAgent'])->name('assign.agent');
    Route::post('/assignAgentSave/{id}/{leadId}', [UserController::class, 'assignAgentSave'])->name('assign.agent-save');



    Route::get('/leads', [LeadController::class, 'index'])->name('leads');
    Route::post('/leads', [LeadController::class, 'leads']);
    Route::get('/status-options', [LoanManagement::class, 'getStatusOptions']);


    Route::inertia('/edit', 'Edit')->name('leads_edit');
    Route::post('/edit/{id}', [LeadController::class, 'update']);
    Route::post('/delete/{id}', [LeadController::class, 'delete'])->name('leads_delete');

    Route::get('/agents', [AgentController::class, 'index'])->name('agents');
    Route::get('/listing', [AgentController::class, 'listing'])->name('listing');
    Route::get('/agent/Basedleads/{id}', [AgentController::class, 'agentBasedleads'])->name('agent.basedLeads');
    Route::get('/cancelAgent/{id}', [AgentController::class, 'cancelAgent'])->name('agent.cancelAgent');

    Route::get('/agents/add-agent', [AgentController::class, 'show'])->name('agents.add-agent');
    Route::post('/agents/add-agent', [AgentController::class, 'add']);
    Route::get('/agents/view-agent/{id}', [AgentController::class, 'view'])->name('agents.view-agent');
    Route::get('/agents/edit-agent/{id}', [AgentController::class, 'edit'])->name('agents.edit-agent');
    Route::put('/agents/update-agent/{id}', [AgentController::class, 'update'])->name('agents.update-agent');
    Route::delete('/agents/delete-agent/{id}', [AgentController::class, 'delete'])->name('agents.delete-agent');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/add-customer', [CustomerController::class, 'show'])->name('customers.add-customer');
    Route::post('/customers/add-customer', [CustomerController::class, 'add']);
    Route::get('/customers/view-customer/{id}', [CustomerController::class, 'view'])->name('customers.view-customer');
    Route::get('/customers/edit-customer/{id}', [CustomerController::class, 'edit'])->name('customers.edit-customer');
    Route::put('/customers/update-customer/{id}', [CustomerController::class, 'update'])->name('customers.update-customer');
    Route::get('/customers/delete-customer/{id}', [CustomerController::class, 'delete'])->name('customers.delete-customer');
    Route::post('/storeAssignAgent/{customerId}', [CustomerController::class, 'storeAssignAgent'])->name('assign.agent-store');

    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals');
    Route::get('/admin/referrals', [ReferralController::class, 'adminIndex'])->name('referrals.admin');
    Route::get('/withdraws', [ReferralController::class, 'indexWithdraw'])->name('withdraws');
    Route::get('/withdraws/approve/receipt/{id}', [ReferralController::class, 'receiptForm'])->name('receipt');
    Route::post('/withdraws/approve/receipt/{id}', [ReferralController::class, 'receiptAdd'])->name('receipt.add');
    Route::get('/withdraws/reject/reason/{id}', [ReferralController::class, 'reasonForm'])->name('reason');
    Route::post('/withdraws/reject/reason/{id}', [ReferralController::class, 'reasonAdd'])->name('reason.add');

    Route::get('/pages', [PagesController::class, 'pages'])->name('pages');
    Route::get('/pages/view/{id}', [PagesController::class, 'viewPages'])->name('pages.view-pages');
    Route::get('/pages/edit/{id}', [PagesController::class, 'editPages'])->name('pages.edit-pages');
    Route::put('/pages/update/{id}', [PagesController::class, 'updatePages'])->name('pages.update-pages');
    Route::get('/pages/delete/{id}', [PagesController::class, 'deletePages'])->name('pages.delete-pages');


    Route::get('/pages/details', [PagesController::class, 'details'])->name('pages.add-details');
    Route::post('/pages/details', [PagesController::class, 'detailSave'])->name('pages.details-save');

    Route::get('/commission', [CommissionController::class, 'commission'])->name('commission');
    Route::get('/add/int/commission', [CommissionController::class, 'addcommission'])->name('add-commission');
    Route::post('/add/int/commission', [CommissionController::class, 'saveCommission'])->name('save-commission');
    Route::get('/add/contact/details', [CommissionController::class, 'addContact'])->name('add-contact');
    Route::post('/add/contact/details', [CommissionController::class, 'saveContact'])->name('save-contact');
});


Route::get('/dashboard', [DashboardController::class, 'dashboardData'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');





Route::middleware(['auth', 'verified','check_user_status'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('user/loan', [LoanController::class, 'index'])->name('user.loan');
    Route::get('dashboard/design', [LoanController::class, 'dashboardDesign'])->name('dasboard.design');


    Route::get('/edit/{id}', [LoanController::class, 'edit'])->name('records.edit');
    Route::post('/records/{id}', [LoanController::class, 'update'])->name('records.update');

    Route::delete('/delete/{id}', [LoanController::class, 'delete'])->name('records.delete');

    Route::get('/loan/view/page/{id}', [LoanController::class, 'loanViewPage'])->name('loan.view.page');

    Route::post('reapply/loan/{id}', [LoanController::class, 'reapplyLoan'])->name('reapply.loan');

    Route::get('user/dashboard', [LoanController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/instruction', [LoanController::class, 'instruction'])->name('instruction');

    Route::get('/withdraw/listing', [LoanController::class, 'withdrawListing'])->name('withdraw.listing');
    Route::get('/reject/loan/reason/{id}', [LoanController::class, 'rejectLoanReason'])->name('reject.loan.reason');

    Route::get('affiliate', [LoanController::class, 'affiliate'])->name('affiliate');
    Route::get('loan/value/{id}', [LoanController::class, 'loanValue'])->name('loan.value');
    Route::post('logout/user', [AuthenticatedSessionController::class, 'destroy'])->name('logout.user');

    Route::get('user/editProfile', [ProfileController::class, 'editProfile'])->name('user.edit.profile');
    Route::put('update/user/profile', [ProfileController::class, 'updateUserProfile'])->name('update.user.profile');

    Route::get('/referral/management', [LoanController::class, 'referralManagement'])->name('referral.management');

    Route::get('loan/successfully',function(){
        return Inertia::render('Frontend/Loan/successfully');
    })->name('loan.successfully');

    Route::post('/referral/withdraw/amount', [LoanController::class, 'withdrawAmount'])->name('withdraw.amount');
    Route::get('user/own/profile', [ProfileController::class, 'userProfile'])->name('user.own.profile');

    Route::get('all-loans',[LoanController::class,'allLoans'])->name('all.loans');

    Route::get('/get/acount/number',[LoanController::class,'getAcountNumber'])->name('get.acount.number');


    Route::get('/current-route',[LoanController::class,'currentRoute'])->name('current.route');
    Route::get('/login/user/name',[LoanController::class,'loginUserName'])->name('login.user.name');
});


        Route::get('/faq', function () {
            return Inertia::render('Frontend/Faqs/index');
        })->name('faq');

        Route::get('/press/details',function(){
            return Inertia::render('Frontend/Press/pressdetails');
        });
        Route::get('/testimonials',function(){
            return Inertia::render('Testimonial/alltestimonials');
        });














Route::get('loan/calculator', [LoanCalculatorController::class, 'index'])->name('loan.calculator');
Route::post('loan/details', [LoanCalculatorController::class, 'details'])->name('loan.details');


Route::get('/press', [NewsController::class,'press_index']);
Route::get('applyloan', [LoanController::class, 'create'])->name('applyloan');
Route::post('loan/store/record', [LoanController::class, 'store'])->name('loan.store.record');
Route::get('loan/success/{applicationId}', [LoanController::class, 'success'])->name('loan.success');
Route::get('/get/footer/data', [LoanController::class, 'getFooterData'])->name('get.footer.data');



require __DIR__ . '/auth.php';

Route::get('/layouts',function(){
    return inertia('Frontend/Layouts/sidebar');
});


