<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Token;
use App\Models\Status;
use App\Mail\LoanReApply;
use App\Mail\LoanApproved;
use App\Mail\LoanRejected;
use App\Mail\LoanTransfred;
use Illuminate\Support\Str;
use App\Mail\CreateLoanMail;
use App\Mail\LoanIncomplete;
use Illuminate\Http\Request;
use App\Mail\LoanFullComplete;
use App\Rules\LoneRuleDocument;
use App\Rules\AtLeastOneRequired;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Validator;

class LoanManagement extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->user_type == 1) {
            // $loanData = Loan::leftjoin('status', 'status.value', '=', 'loans.status')
            //     ->where('is_deleted', 0)
            //     ->orderBy('id', 'desc')
            //     ->select('loans.*', 'status.name as status','status.value as statusValue')
            //     ->get();
            // $loanData = Loan::leftJoin('status', 'status.value', '=', 'loans.status')
            //     ->leftJoin('users', 'users.id', '=', 'loans.user_id')
            //     ->where('loans.is_deleted', 0)
            //     ->orderBy('loans.id', 'desc')
            //     ->select('loans.*', 'status.name as status', 'status.value as statusValue', 'users.email as user_email')
            //     ->get();

            $loanData = Loan::leftJoin('status', 'status.value', '=', 'loans.status')
    ->leftJoin('users', 'users.id', '=', 'loans.user_id')
    ->where('loans.is_deleted', 0)
    ->orderBy('loans.id', 'desc')
    ->select(
        'loans.*',
        'status.name as status',
        'status.value as statusValue',
        'users.email as user_email',
        'users.name as user_name' // Include the name column from the users table
    )
    ->get();






        } elseif ($user->user_type == 2) {
            // $loanData = Loan::leftjoin('status', 'status.value', '=', 'loans.status')
            //     ->where('is_deleted', 0)->where('assigned_to',Auth::user()->id)
            //     ->orderBy('id', 'desc')
            //     ->select('loans.*', 'status.name as status','status.value as statusValue')
            //     ->get();

            $loanData = Loan::leftJoin('status', 'status.value', '=', 'loans.status')
                ->leftJoin('users', 'users.id', '=', 'loans.user_id')
                ->where('loans.is_deleted', 0)
                ->where('loans.assigned_to', Auth::user()->id)
                ->orderBy('loans.id', 'desc')
                ->select('loans.*', 'status.name as status', 'status.value as statusValue', 'users.email as user_email', 'users.name as user_name')
                ->get();
        }

        $user_type = Auth::user()->user_type;

        return Inertia::render('Loan-Management/index', ['loanData' => $loanData, 'authUser' => $user,'user_type'=>$user_type]);
    }
    // public function create()
    // {
    //     return Inertia::render('Loan-Management/create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'applicant_name' => 'required|string',
    //         'loan_amount' => 'required|numeric|gt:0',
    //         'installments' => 'required|numeric|gt:0',
    //         'date' => 'required',
    //         'documents.*' => 'required|mimes:jpg,png,pdf,doc,docx|max:2048',
    //     ]);

    //     $loan = Loan::create([
    //         'applicant_name' => $request->applicant_name,
    //         'loan_amount' => $request->loan_amount,
    //         'installments' => $request->installments,
    //         'date' => $request->date,

    //     ]);

    //     // $loan->user()->associate(auth()->user());
    //     if ($request->hasFile('documents')) {
    //         $documents = [];
    //         foreach ($request->file('documents') as $document) {
    //             $path = $document->store('loan_documents', 'public');
    //             $loanDocument = new LoanDocument(['document' => $path]);
    //             $loan->documents()->save($loanDocument);
    //             $documents[] = $loanDocument->id;
    //         }
    //         $loan->documents_id = $documents;
    //     }
    //     $loan->save();

    //     return redirect()->route('loan.index');
    // }
    public function create()
    {
        $authUser = Auth::user();

        if($authUser->user_type == 1){
            $customers = User::where(['user_type' => 3, 'is_deleted' => 0])->get();
        }elseif($authUser->user_type == 2){
            // $customers = User::where(['is_deleted' => 0,'agent_id'=>$authUser->id])->get();
            $customers = User::where(['is_deleted' => 0,'user_type' => 3])->get();
            // dd($customers);
        }
        // dd($customers);
        return Inertia::render('Loan-Management/create', ['customers' => $customers]);
    }

    public function store(Request $request)
    {

        $rules = [
            'documentOption' => ['required', new LoneRuleDocument(['dlFrontPhoto', 'dlBackPhoto', 'ssnFrontPhoto', 'ssnBackPhoto'])],
            'receiveLoanThrough' => ['required', new AtLeastOneRequired(['pixKey', 'cardNumber', 'printedName', 'date'])],
            'loan_amount' => 'required|numeric|gt:0',
            'applicant_id' => 'required',
            'numberOfmonths' => 'required',
            'limitAvailable' => 'required',
            'frontCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'backCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'frontCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'backCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cardLimitScreenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'declarationCheckbox' => 'required',
        ];

        $customMessages = [
            'applicant_id.required' => 'The applicant name is required.',
            'numberOfmonths.required' => 'Please select the number of months.',
            'receiveLoanThrough.required' => 'Please select how you will receive the loan.',
            'documentOption.required' => 'Please choose a document option.',
            'limitAvailable.required' => 'Please provide information about the available limit.',
            'frontCardSelfie.required' => 'Please upload a front card selfie image.',
            'frontCardSelfie.image' => 'The front card selfie must be an image.',
            'frontCardSelfie.mimes' => 'The front card selfie must be a valid image file (jpeg, png, jpg, gif).',
            'frontCardSelfie.max' => 'The front card selfie may not be greater than 2048 kilobytes.',

            'backCardSelfie.required' => 'Please upload a back card selfie image.',
            'backCardSelfie.image' => 'The back card selfie must be an image.',
            'backCardSelfie.mimes' => 'The back card selfie must be a valid image file (jpeg, png, jpg, gif).',
            'backCardSelfie.max' => 'The back card selfie may not be greater than 2048 kilobytes.',

            'frontCardImage.required' => 'Please upload a front card image.',
            'frontCardImage.image' => 'The front card image must be an image.',
            'frontCardImage.mimes' => 'The front card image must be a valid image file (jpeg, png, jpg, gif).',
            'frontCardImage.max' => 'The front card image may not be greater than 2048 kilobytes.',

            'backCardImage.required' => 'Please upload a back card image.',
            'backCardImage.image' => 'The back card image must be an image.',
            'backCardImage.mimes' => 'The back card image must be a valid image file (jpeg, png, jpg, gif).',
            'backCardImage.max' => 'The back card image may not be greater than 2048 kilobytes.',

            'cardLimitScreenshot.required' => 'Please upload a card limit screenshot.',
            'cardLimitScreenshot.image' => 'The card limit screenshot must be an image.',
            'cardLimitScreenshot.mimes' => 'The card limit screenshot must be a valid image file (jpeg, png, jpg, gif).',
            'cardLimitScreenshot.max' => 'The card limit screenshot may not be greater than 2048 kilobytes.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        $error = false;
        $authUser = Auth::user();
        if ($request->referralordiscount == 0) {

            if ($request->has('referralLink') && $request->referralLink != null) {
                $exists = User::where('referralCode', $request->referralLink)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('referralLink', "This Referal Code doesn't exists!");
                }
            }

            $customer = User::where('id', $request->applicant_id)->first();

            $myrefrelLink = $request->referralLink;

            if ($customer) {
                $existingLoan = Loan::where('user_id', $customer->id)
                    ->whereNotNull('referralLink')
                    ->where('referralLink', $myrefrelLink)
                    ->first();

                if ($existingLoan) {
                    $error = true;
                    $validator->errors()->add('referralLink', "Referral link has already been used by you for a previous loan. You cannot use now referral link again.");
                }
            }
        } elseif ($request->referralordiscount == 1) {
            if ($request->has('discount_code') && $request->discount_code != null) {
                $exists = User::where('user_type', 1)->where('referralcode', $request->discount_code)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('discount_code', "This discount Code doesn't exists!");
                }
            }
            $customer = User::where('id', $request->applicant_id)->first();
            $discountlink = $request->discount_code;

            if ($customer) {
                $existingLoan = Loan::where('user_id', $customer->id)
                    ->whereNotNull('discount_code')
                    ->where('discount_code', $discountlink)
                    ->first();

                if ($existingLoan) {
                    $error = true;
                    $validator->errors()->add('discount_code', "Discount code has already been used by you for a previous loan. You cannot use now discount code again.");
                }
            }
        }

        if ($error) {
            return redirect()->back()->withErrors($validator)->withInput();
        }








        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('ssnFrontPhoto')) {
            $image = $request->file('ssnFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('ssnBackPhoto')) {
            $image = $request->file('ssnBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlFrontPhoto')) {
            $image = $request->file('dlFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlBackPhoto')) {
            $image = $request->file('dlBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('frontCardSelfie')) {
            $image = $request->file('frontCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('backCardSelfie')) {
            $image = $request->file('backCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('frontCardImage')) {
            $image = $request->file('frontCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardImageOriginalName = $name;
        }

        if ($request->hasFile('backCardImage')) {
            $image = $request->file('backCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardImageOriginalName = $name;
        }

        if ($request->hasFile('cardLimitScreenshot')) {
            $image = $request->file('cardLimitScreenshot');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $cardLimitScreenshotOriginalName = $name;
        }

        $referralLink = $request->referralLink;
        $user = User::where('referralcode', $referralLink)->first();

        $mailData = [
            'title' => 'Mail from Vision Vivante',
            'body' => 'Mai loan lena chahta hu',
        ];

        // Mail::to(Auth::user()->email)->send(new CreateLoanMail($mailData));

        // dd($customer);
        $loan = new Loan();
        $loan->applicant_name = $customer->name;
        $loan->installments = $request->instalamount;
        $loan->loan_amount = $request->loan_amount ?? "";
        $loan->numberofinstallment = $request->numberofinstallment ?? "";
        $loan->numberOfmonths = $request->numberOfmonths ?? "";
        $loan->receiveLoanThrough = $request->receiveLoanThrough ?? "";
        $loan->pixKey = $request->pixKey ?? "";
        $loan->cardNumber = $request->cardNumber ?? "";
        $loan->printedName = $request->printedName ?? "";
        $loan->date = date('Y-m-d');
        $loan->documentOption = $request->documentOption ?? "";
        $loan->ssnFrontPhoto = $ssnFrontPhotoOriginalName ?? "";
        $loan->ssnBackPhoto = $ssnBackPhotoOriginalName ?? "";
        $loan->drivingLicense = $request->drivingLicense ?? "";
        $loan->dlFrontPhoto = $dlFrontPhotoOriginalName ?? "";
        $loan->dlBackPhoto = $dlBackPhotoOriginalName ?? "";
        $loan->frontCardSelfie = $frontCardSelfieOriginalName ?? "";
        $loan->backCardSelfie = $backCardSelfieOriginalName ?? "";
        $loan->backCardImage = $backCardImageOriginalName ?? "";
        $loan->frontCardImage = $frontCardImageOriginalName ?? "";
        $loan->cardLimitScreenshot = $cardLimitScreenshotOriginalName ?? "";
        $loan->limitAvailable = $request->limitAvailable ?? null;
        $loan->declarationCheckbox = $request->declarationCheckbox ?? "";
        $loan->created_by = $authUser->id;
        $loan->discount_code = $request->discount_code ?? "";
        // if ($authUser->user_type == 2) {
        //     $loan->assigned_to = $authUser->id;
        // }
        if ($user) {
            $loan->referralLink = $request->referralLink;
        }
        $loan->user_id = $customer->id;
        $loan->save();

        // $rds = new LeadController();
        // $rds->post_leads($loan);

        return redirect()->route('loan.index');
    }
    public function show($id)
    {
        $loanData = Loan::LeftJoin('status', 'status.value', '=', 'loans.status')
            ->where('is_deleted', 0)
            ->where('loans.id', $id)
            ->select('loans.*', 'status.name as status')
            ->first();
        // dd($loanData);
        // dd($loandata);
        // if ($loandata->documents_id != null) {
        //     $documentIds = json_decode($loandata->documents_id, true);

        //     $loanDocument = LoanDocument::whereIn('id', $documentIds)->get();

        //     foreach ($loanDocument as $document) {
        //         $document->url = Storage::disk('public')->url($document->document);
        //     }
        //     // dd($loanDocument);
        //     return Inertia::render('Loan-Management/view', ['loanData' => $loandata, 'documents' => $loanDocument]);
        // } else {
        //     return Inertia::render('Loan-Management/edit', ['loanData' => $loandata]);
        // }
        // $loanData->cardLimitScreenshotImage = Storage::disk('public')->url('Loan Image/'.$loanData->cardLimitScreenshot);

        $loanData->cardLimitScreenshot = $loanData->cardLimitScreenshot
        ? Storage::disk('local')->url($loanData->cardLimitScreenshot)
        : null;

        $loanData->dlFrontPhoto = $loanData->dlFrontPhoto
        ? Storage::disk('local')->url($loanData->dlFrontPhoto)
        : null;
        $loanData->dlBackPhoto = $loanData->dlBackPhoto
        ? Storage::disk('local')->url($loanData->dlBackPhoto)
        : null;
        $loanData->frontCardSelfie = $loanData->frontCardSelfie
        ? Storage::disk('local')->url($loanData->frontCardSelfie)
        : null;
        $loanData->backCardSelfie = $loanData->backCardSelfie
        ? Storage::disk('local')->url($loanData->backCardSelfie)
        : null;
        $loanData->frontCardImage = $loanData->frontCardImage
        ? Storage::disk('local')->url($loanData->frontCardImage)
        : null;
        $loanData->backCardImage = $loanData->backCardImage
        ? Storage::disk('local')->url($loanData->backCardImage)
        : null;

        $loanData->ssnFrontPhoto = $loanData->ssnFrontPhoto
        ? Storage::disk('local')->url($loanData->ssnFrontPhoto)
        : null;
        $loanData->ssnBackPhoto = $loanData->ssnBackPhoto
        ? Storage::disk('local')->url($loanData->ssnBackPhoto)
        : null;



        $loanData->loan_complete_proof = $loanData->loan_complete_proof
        ? Storage::disk('local')->url($loanData->loan_complete_proof)
        : null;

        // dd($loanData->loan_complete_proof);




        return Inertia::render('Loan-Management/view', ['loanData' => $loanData]);
    }
    public function edit($id)
    {
        $record = Loan::where(['id' => $id, 'is_deleted' => 0])->first();
        $record->cardLimitScreenshotImage = Storage::disk('local')->url($record->cardLimitScreenshot);
        $record->dlFrontPhoto = Storage::disk('local')->url($record->dlFrontPhoto);
        $record->dlBackPhoto = Storage::disk('local')->url($record->dlBackPhoto);
        $record->frontCardSelfie = Storage::disk('local')->url($record->frontCardSelfie);
        $record->backCardSelfie = Storage::disk('local')->url($record->backCardSelfie);
        $record->frontCardImage = Storage::disk('local')->url($record->frontCardImage);
        $record->backCardImage = Storage::disk('local')->url($record->backCardImage);
        $record->ssnFrontPhoto = Storage::disk('local')->url($record->ssnFrontPhoto);

        $record->ssnBackPhoto = Storage::disk('local')->url($record->ssnBackPhoto);

        return Inertia::render('Loan-Management/edit', ['record' => $record]);

    }


    public function update(Request $request, $id)
    {
        $rules = [

            'loan_amount' => 'required|numeric|min:1',
            'numberOfmonths' => 'required',
            'limitAvailable' => 'required',
            'receiveLoanThrough' => ['required', new AtLeastOneRequired(['pixKey', 'cardNumber', 'printedName', 'date'])],
            'declarationCheckbox' => 'required',
        ];



        $messages = [
            'numberOfmonths.required' => 'The number of months is required.',
            'limitAvailable.required' => 'The limit available is required.',
            'receiveLoanThrough.required' => 'At least one of the payment methods is required.',

            // 'pixdata.required' => 'This field is required.',
            // 'pixdata.digits' => 'This field must be :digits digits.',
            // 'pixdata.email' => 'This field must be a valid email address.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $error = false;
        $user_id = Auth::user()->id;
        if ($request->referralordiscount == 0) {
            if ($request->has('referralLink') && $request->referralLink != null) {
                $exists = User::where('referralCode', $request->referralLink)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('referralLink', "This Referal Code doesn't exists!");
                }
            }
            $loan = Loan::find($id);
            $referralLink = $request->referralLink;

            if ($loan) {
                $existingLoan = Loan::where('user_id', $loan->user_id)
                    ->whereNotNull('referralLink')
                    ->where('referralLink', $request->referralLink)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingLoan) {
                    $error = true;
                    $validator->errors()->add('referralLink', "Referral link has already been used by you for a previous loan. You cannot use the same referral link again.");
                }
            }
        } elseif ($request->referralordiscount == 1) {
            if ($request->has('discount_code') && $request->discount_code != null) {
                $exists = User::where('user_type', 1)->where('referralcode', $request->discount_code)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('discount_code', "This discount Code doesn't exists!");
                }
            }
            $customer = User::where('id', $request->applicant_id)->first();
            $discountlink = $request->discount_code;

            if ($customer) {
                $existingLoan = Loan::where('user_id', $customer->id)
                    ->whereNotNull('discount_code')
                    ->where('discount_code', $discountlink)
                    ->where('id', '!=', $id)
                    ->first();
                if ($existingLoan) {
                    $error = true;
                    $validator->errors()->add('discount_code', "Discount code has already been used by you for a previous loan. You cannot use now discount code again.");
                }
            }
        }

        if ($error) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('ssnFrontPhoto')) {
            $image = $request->file('ssnFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('ssnBackPhoto')) {
            $image = $request->file('ssnBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlFrontPhoto')) {
            $image = $request->file('dlFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlBackPhoto')) {
            $image = $request->file('dlBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('frontCardSelfie')) {
            $image = $request->file('frontCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('backCardSelfie')) {
            $image = $request->file('backCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('frontCardImage')) {
            $image = $request->file('frontCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardImageOriginalName = $name;
        }

        if ($request->hasFile('backCardImage')) {
            $image = $request->file('backCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardImageOriginalName = $name;
        }

        if ($request->hasFile('cardLimitScreenshot')) {
            $image = $request->file('cardLimitScreenshot');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $cardLimitScreenshotOriginalName = $name;
        }
        $referralLink = $request->referralLink;
        $user = User::where('referralcode', $referralLink)->first();

        if ($loan) {
            $loan->loan_amount = $request->loan_amount ?? '';
            $loan->numberofinstallment = $request->numberofinstallment ?? " ";
            $loan->numberOfmonths = $request->numberOfmonths ?? '';
            $loan->cardNumber = $request->cardNumber ?? "";
            $loan->printedName = $request->printedName ?? "";
            $loan->date = $request->date ? date('Y-m-d H:i:s', strtotime($request->date)) : null;
            $loan->pixKey = $request->pixKey ?? "";
            $loan->receiveLoanThrough = $request->receiveLoanThrough ?? '';
            $loan->documentOption = $request->documentOption ?? '';
            $loan->discount_code = $request->discount_code ?? "";
            $loan->created_by = $user_id;
            if ($user) {
                $loan->referralLink = $request->referralLink;
            }

            if (isset($ssnFrontPhotoOriginalName)) {
                $loan->ssnFrontPhoto = $ssnFrontPhotoOriginalName;
            }
            if (isset($ssnBackPhotoOriginalName)) {
                $loan->ssnBackPhoto = $ssnBackPhotoOriginalName;
            }
            if (isset($dlFrontPhotoOriginalName)) {
                $loan->dlFrontPhoto = $dlFrontPhotoOriginalName;
            }
            if (isset($dlBackPhotoOriginalName)) {
                $loan->dlBackPhoto = $dlBackPhotoOriginalName;
            }
            if (isset($frontCardSelfieOriginalName)) {
                $loan->frontCardSelfie = $frontCardSelfieOriginalName;
            }
            if (isset($backCardSelfieOriginalName)) {
                $loan->backCardSelfie = $backCardSelfieOriginalName;
            }
            if (isset($frontCardImageOriginalName)) {
                $loan->frontCardImage = $frontCardImageOriginalName;
            }
            if (isset($backCardImageOriginalName)) {
                $loan->backCardImage = $backCardImageOriginalName;
            }
            if (isset($cardLimitScreenshotOriginalName)) {
                $loan->cardLimitScreenshot = $cardLimitScreenshotOriginalName;
            }
            $loan->limitAvailable = $request->limitAvailable;

            $loan->save();
        } else {

        }

        return redirect()->route('loan.index');

    }
    public function delete($id)
    {
        $loan = Loan::find($id);
        $loan->update(['is_deleted' => $loan->is_deleted ? 0 : 1]);
    }
    public function deletedLoan()
    {
        $user = Auth::user();
        if($user->user_type == 1){
            $loan = Loan::where('is_deleted', 1)->get();
        }elseif($user->user_type == 2){

            $agentUsers = User::where(['user_type'=>3,'is_deleted'=> 0])->get();

            if ($agentUsers) {
                $userIds = $agentUsers->pluck('id')->toArray();
                $loan = Loan::with('getAgent')
                ->where('is_deleted', 1)->where('assigned_to',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->whereIn('user_id', $userIds)->get();
            }
        }
        return Inertia::render('Loan-Management/deletedLoan', ['loanData' => $loan]);
    }
    public function deletePermanent($id)
    {
        $loan = Loan::find($id);
        if ($loan) {
            Storage::disk('local')->delete($loan->ssnFrontPhoto);
            Storage::disk('local')->delete($loan->ssnBackPhoto);
            Storage::disk('local')->delete($loan->dlFrontPhoto);
            Storage::disk('local')->delete($loan->dlBackPhoto);
            Storage::disk('local')->delete($loan->frontCardSelfie);
            Storage::disk('local')->delete($loan->backCardSelfie);
            Storage::disk('local')->delete($loan->backCardImage);
            Storage::disk('local')->delete($loan->cardLimitScreenshot);
            Storage::disk('local')->delete($loan->frontCardImage);
            $loan->delete();
        } else {
            return "Loan not found.";
        }
    }

    public function getAssignedLoan()
    {
        $user = Auth::user();
        if($user->user_type == 1){
            $loans = Loan::where('assigned_to', '!=', 0)
                ->where('is_deleted', 0)
                ->get();


        }elseif ($user->user_type == 2) {
            $loans = Loan::where('assigned_to', $user->id)
                ->where('is_deleted', 0)
                ->get();
        }
        return Inertia::render('Loan-Management/assignedLoan', ['loans' => $loans]);
    }

    public function approved()
    {
        $user = Auth::user();
        if($user->user_type == 1){
            $approve_loan = Loan::with('getAgent')->where(['status' => 1, 'is_deleted' => 0])->get();
        }elseif($user->user_type == 2){
            $approve_loan = Loan::with('getAgent')
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->where('assigned_to', Auth::user()->id)
            ->get();
        }
        return Inertia::render('Loan-Management/ApprovedLoan', ['approve_loan' => $approve_loan]);
    }
    public function rejectedList()
    {
        $user = Auth::user();
        if($user->user_type == 1){
            $rejected = Loan::with('getAgent')->where(['status' => 2, 'is_deleted' => 0])->get();
        }elseif($user->user_type == 2){
            $rejected = Loan::with('getAgent')
            ->where('status', 2)
            ->where('is_deleted', 0)
            ->where('assigned_to', Auth::user()->id)
            ->get();
        }

        return Inertia::render('Loan-Management/RejectedLoan', ['rejected_loan' => $rejected]);
    }

    public function storeAssignAgent(Request $request, $loanId)
    {
        try {
            $user = Loan::where('id', $loanId)->update([
                'assigned_to' => $request->agent,
            ]);
            return Inertia::location(route('loan.index'))->with('success', 'Agent assigned successfully');
        } catch (\Exception $e) {
            return Inertia::location(route('loan.index'));
        }
    }
    public function changeStatus(Request $request, $loanid)
    {
            $loan = Loan::find($loanid);
            try {
                $loan = Loan::where('id', $loanid)->first();

                if ($request->hasFile('loanTransferProof')) {
                    $file = $request->file('loanTransferProof');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/loanTransferProof', $fileName);
                    $dataToUpdate['loan_complete_proof'] = $filePath;
                     $loan->loan_complete_proof  = $filePath;
                }


                if ($loan) {
                    if ($loan) {
                        $dataToUpdate = ['status' => $request->status];

                        if ($request->has('incompleteReason')) {
                            $loan->incompletereson = $request->incompleteReason;
                        }

                        $loan->update($dataToUpdate);
                    }


                    $user = User::where('id', $loan->user_id)->select('users.*')->first();
                    $email = $user->email;
                    $username = $user->name;
                    $creator = Auth::user()->name;
                    if ($request->status == 1) {
                        Mail::to($email)->send(new LoanApproved($username, $email, $creator));

                    } elseif ($request->status == 2) {
                        Mail::to($email)->send(new LoanRejected($username, $email, $creator));
                    }elseif ($request->status == 3) {
                        Mail::to($email)->send(new LoanIncomplete($username, $email, $creator));
                    }elseif ($request->status == 4) {
                        Mail::to($email)->send(new LoanFullComplete($username, $email, $creator));
                    }elseif ($request->status == 4) {
                        Mail::to($email)->send(new LoanFullComplete($username, $email, $creator));
                    }elseif ($request->status == 5) {
                        Mail::to($email)->send(new LoanReApply($username, $email, $creator));
                    }elseif ($request->status == 6) {
                        Mail::to($email)->send(new LoanTransfred($username, $email, $creator));
                    }



                    // Re-Apply





                    $loan = Loan::find($loanid);

                    $rds = new LeadController();
                    $rds->post_leads($loan);

                    return Inertia::location(route('loan.index'))
                        ->with('success', 'Status changed successfully');
                }
            } catch (\Exception $e) {
                return Inertia::location(route('loan.index'));

            }

    }
    public function getStatusOptions()
    {
        $status = Status::all();
        return response()->json($status);
    }


    public function loanStoreBackendRecord(Request $request)
    {

        // $users = User::where('user_type',2)->where('is_deleted',0)->with('loans')->get();

        // $no_of_loans = 0;
        // $assign_to = null;
        // foreach($users as $key => $user){
        //     $loans = count($user->loans);
        //     if($key == 0){
        //         $no_of_loans = $loans;
        //         $assign_to = $user->id;
        //     }elseif($no_of_loans > $loans){
        //         $no_of_loans = $loans;
        //         $assign_to = $user->id;
        //     }
        // }
        // pixcpf

        $rules = [
            'declarationCheckbox' => 'required|accepted',
            'loan_amount' => 'required|numeric|gt:0',
            'limitAvailable' => 'required|numeric|gt:0',
            'numberOfmonths' => 'required',
            'frontCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'backCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'frontCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'backCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cardLimitScreenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cardNumber' => 'required|numeric|digits:16',
            'printedName' => 'required',
            'date' => ['required', 'after_or_equal:today'],
            'cvv' => 'required|digits:3|numeric',
            'eemail' => Auth::check() ? 'nullable' : 'required|unique:users,email',
            'password' => Auth::check() ? 'nullable' : 'required|min:8',

        ];

        if ($request->input('documentOption') === 'ssn') {
            $rules['ssnFrontPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['ssnBackPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($request->input('documentOption') === 'drivingLicense') {
            $rules['dlFrontPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['dlBackPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if (Auth::user()->user_type == 2 || Auth::user()->user_type == 1) {
            $rules['applicant_id'] = 'required';
        }


        if ($request->input('receiveLoanThrough') === '0') {
            $rules['pixdata'] = 'required_without_all:bankcode,agencyNumber,currentAccountNumber,cpf';

            // if ($request->input('pixtype') == 'pixcpf') {
            //     $rules['pixdata'] = 'required | digits:11';
            // }

            // if ($request->input('pixtype') == 'email') {
            //     $rules['pixdata'] = 'required | email';
            // }

            // if ($request->input('pixtype') == 'phonenumber') {
            //     $rules['pixdata'] = 'required | digits:9';
            // }

            // if ($request->input('pixtype') == 'randomkey') {
            //     $rules['pixdata'] = 'required';
            // }

            if ($request->input('pixtype') == 'pixcpf') {
                $rules['pixdata'] = 'required|digits:11';
            } elseif ($request->input('pixtype') == 'email') {
                $rules['pixdata'] = 'required|email';
            } elseif ($request->input('pixtype') == 'phonenumber') {
                $rules['pixdata'] = 'required|digits:11';
            } elseif ($request->input('pixtype') == 'randomkey') {
                $rules['pixdata'] = 'required';
            }


        } elseif ($request->input('receiveLoanThrough') === '1') {
            $rules += [
                'bankcode' => 'required',
                'agencyNumber' => 'required',
                'currentAccountNumber' => 'required',
                'cpf' => 'required | digits:11',
            ];
        }


        // if ($request->input('pixtype') === 'pixcpf') {
        //     $rules['pixcpf'] = 'required | digits:11';
        // }

        $customMessages = [
            'ssnFrontPhoto.required'=> 'RG front photo is required',
            'ssnBackPhoto.required'=> 'RG back photo is required',
            // 'pixcpf.digits' => 'CPF must be 11 numeric digits.',
            // 'cpf.digits' => 'CPF must be 11 numeric digits.',
            // 'pixdata.required' => 'This field is required.',
            // 'pixdata.digits' => 'This field must be 11 numeric digits.',

            'pixdata.required' => 'The PIX data field is required.',
            'pixdata.digits' => 'This field must be :digits digits.',
            'pixdata.email' => 'This field must be a valid email address.',



            'applicant_id.required' => 'This field is required',
            'printedName.required' => 'This field is required',
            'printedName.alpha' => 'The printed name must contain only alphabetic characters.',

            'cardNumber.required' => 'This field is required',
            'cardNumber.numeric' => 'The Card Number field must be Numeric',
            'cardNumber.digits' => 'The Card number field must have 16 numeric digits',

            'date.required' => 'This field is required',
            'date.after_or_equal' => 'The date must be after or equal to today.',

            'cvv.required' => 'This field is required',
            'cvv.digits' => 'Cvv must have three digits',
            'cvv.numeric' => 'CVV must be numerical',

            'discount_code.in' => 'Invalid discount code.',

            'loan_amount.required' => 'This field is required.',
            'numberofinstallment.required' => 'This field is required.',
            'numberOfmonths.required' => 'This field is required.',
            'receiveLoanThrough.required' => 'This field is required.',
            'documentOption.required' => 'This field is required.',
            'limitAvailable.required' => 'This field is required.',
            'frontCardSelfie.required' => 'This field is required.',
            'frontCardSelfie.image' => 'The front card selfie must be a picture.',
            'frontCardSelfie.mimes' => 'Front card selfie must be a valid image file (jpeg, png, jpg, gif).',
            'frontCardSelfie.max' => 'Front card selfie must be a valid image file (jpeg, png, jpg, gif)',

            'backCardSelfie.required' => 'This field is required.',
            'backCardSelfie.image' => 'The selfie on the back of the card must be an image.',
            'backCardSelfie.mimes' => 'The selfie on the back of the card must be a valid image file (jpeg, png, jpg, gif).',
            'backCardSelfie.max' => 'The back card selfie cannot be larger than 2,048 kilobytes.',

            'frontCardImage.required' => 'This field is required.',
            'frontCardImage.image' => 'The front image of the card must be a picture.',
            'frontCardImage.mimes' => 'The front image of the card must be a valid image file (jpeg, png, jpg, gif).',
            'frontCardImage.max' => 'The front image of the card cannot be larger than 2,048 kilobytes.',

            'backCardImage.required' => 'This field is required.',
            'backCardImage.image' => 'The image on the back of the card must be a picture.',
            'backCardImage.mimes' => 'The image on the back of the card must be a valid image file (jpeg, png, jpg, gif).',
            'backCardImage.max' => 'The image on the back of the card cannot be larger than 2,048 kilobytes.',

            'cardLimitScreenshot.required' => 'This field is required.',
            'cardLimitScreenshot.image' => 'The card limit screenshot must be an image.',
            'cardLimitScreenshot.mimes' => 'The card limit screenshot must be a valid image file (jpeg, png, jpg, gif).',
            'cardLimitScreenshot.max' => 'The card limit screenshot may not be greater than 2048 kilobytes.',
            'declarationCheckbox.accepted' => 'Select the check box.',
            'declarationCheckbox.required' => 'Select the check box.',
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $error = false;

        if(Auth::user() && Auth::user()->user_type == 3){
            $ownReferralcode = Auth::user()->referralcode;

            if($request->referralLink ==  $ownReferralcode){
                $error = true;
                $validator->errors()->add('referralLink', "Você não pode usar seu próprio código de referência!");
            }
        }

        // End Auth User

        if ((Auth::check() && Auth::user()->user_type !== null)) {
            if ($request->has('referralLink') && $request->referralLink != null && Auth::user()->user_type == 3) {
                $exists = User::where('referralCode', $request->referralLink)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('referralLink', "Este código de referência não existe!");
                }
            }
        }



        $discountcodeOfSuperAdmin = User::where('user_type', 1)->first()?->referralcode;

        if (isset($request->discount_code) && $discountcodeOfSuperAdmin !== $request->discount_code && Auth::user()->user_type == 3) {
            $error = true;
            $validator->errors()->add('discount_code', "Este código de desconto não existe!");
        }

        if (!Auth::user()) {
            $referralCode = Str::random(10);
            $user = User::create([
                'name' => 'User',
                'email' => $request->eemail,
                'password' => Hash::make($request->password),
                'referralcode' => $referralCode,
                'user_type' => 3,
            ]);
            $user->sendEmailVerificationNotification();
            Auth::login($user);
        }

        if (Auth::user() && Auth::user()->user_type == 3) {
            $user_id = Auth::user()->id;
            $myrefrelLink = $request->referralLink;

            $existingLoan = Loan::where('user_id', $user_id)
                ->whereNotNull('referralLink')
                ->where('referralLink', $myrefrelLink)
                ->first();

            if (isset($existingLoan->referralLink)) {
                $error = true;
                $validator->errors()->add('referralLink', "O link de referência já foi usado por você para um empréstimo anterior. Você não pode usar o link de referência novamente.");
            }
        }

        if ($error) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('ssnFrontPhoto')) {
            $image = $request->file('ssnFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('ssnBackPhoto')) {
            $image = $request->file('ssnBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $ssnBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlFrontPhoto')) {
            $image = $request->file('dlFrontPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlFrontPhotoOriginalName = $name;
        }

        if ($request->hasFile('dlBackPhoto')) {
            $image = $request->file('dlBackPhoto');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $dlBackPhotoOriginalName = $name;
        }

        if ($request->hasFile('frontCardSelfie')) {
            $image = $request->file('frontCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('backCardSelfie')) {
            $image = $request->file('backCardSelfie');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardSelfieOriginalName = $name;
        }

        if ($request->hasFile('frontCardImage')) {
            $image = $request->file('frontCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $frontCardImageOriginalName = $name;
        }

        if ($request->hasFile('backCardImage')) {
            $image = $request->file('backCardImage');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $backCardImageOriginalName = $name;
        }

        if ($request->hasFile('cardLimitScreenshot')) {
            $image = $request->file('cardLimitScreenshot');
            $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($name, file_get_contents($image));
            $cardLimitScreenshotOriginalName = $name;
        }

        $referralLink = $request->referralLink;

        $user = User::where('referralcode', $referralLink)->first();

        if (isset($request->email) && $request->email != "") {
            $mailData = [
                'title' => 'Hi User: ' . $request->email,
                'body' => 'Uma solicitação de empréstimo foi enviada.',
            ];
        } else {
            $mailData = [
                'title' => 'Hi User: ' . $request->eemail,
                'body' => 'Uma solicitação de empréstimo foi enviada.',

            ];
        }

        if (Auth::user()) {
            Mail::to(Auth::user()->email)->send(new CreateLoanMail($mailData));
        } else {
            Mail::to($request->eemail)->send(new CreateLoanMail($mailData));
        }

        $applicationId = Str::random(14);
        // Start Assigenned To logic
        $users = User::where('user_type',2)->where('is_deleted',0)->with('loans')->get();

        $no_of_loans = 0;
        // $assign_to = null;
        $assign_to = 0;
        foreach($users as $key => $user){
            $loans = count($user->loans);
            if($key == 0){
                $no_of_loans = $loans;
                $assign_to = $user->id;
            }elseif($no_of_loans > $loans){
                $no_of_loans = $loans;
                $assign_to = $user->id;
            }
        }
        // End Assigened To logic

        $commission = DB::table('interest_commission')->latest()->first();
        $commissionValue = $commission->commission ?? 0;


        $user_id = Auth::user()->id;
        $loan = new Loan();

        $loan->installments = $request->instalamount;
        $loan->loan_amount = $request->loan_amount ?? "";
        $loan->numberofinstallment = $request->numberofinstallment ?? "";
        $loan->numberOfmonths = $request->numberOfmonths ?? "";
        $loan->receiveLoanThrough = $request->receiveLoanThrough ?? "";
        $loan->cardNumber = $request->cardNumber ?? "";
        $loan->printedName = $request->printedName ?? "";
        $loan->date = $request->date ?? "";
        $loan->documentOption = $request->documentOption ?? "";
        $loan->ssnFrontPhoto = $ssnFrontPhotoOriginalName ?? "";
        $loan->ssnBackPhoto = $ssnBackPhotoOriginalName ?? "";
        $loan->drivingLicense = $request->drivingLicense ?? "";
        $loan->dlFrontPhoto = $dlFrontPhotoOriginalName ?? "";
        $loan->dlBackPhoto = $dlBackPhotoOriginalName ?? "";
        $loan->frontCardSelfie = $frontCardSelfieOriginalName ?? "";
        $loan->backCardSelfie = $backCardSelfieOriginalName ?? "";
        $loan->backCardImage = $backCardImageOriginalName ?? "";
        $loan->frontCardImage = $frontCardImageOriginalName ?? "";
        $loan->cardLimitScreenshot = $cardLimitScreenshotOriginalName ?? "";
        $loan->limitAvailable = $request->limitAvailable ?? null;
        $loan->declarationCheckbox = $request->declarationCheckbox ?? "";
        $loan->discount_code = $request->discountcode ?? "";
        $loan->bankcode = $request->bankcode ?? "";
        $loan->agencyNumber = $request->agencyNumber ?? "";
        $loan->commission = $commissionValue ?? "";

        if(Auth::user()->user_type == 1){
            $loan->assigned_to = $assign_to ?? "";
        }else{
            $loan->assigned_to = Auth::user()->id;
        }

        $loan->currentAccountNumber = $request->currentAccountNumber ?? "";

        if(isset($request->applicant_id)){
            $loan->user_id = $request->applicant_id;
        }

        if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            $customer = User::where('id', $request->applicant_id)->first();
            $loan->applicant_name = $customer->name;
        }else{
            $loan->applicant_name = Auth::user()->name;
        }

       // Here
        if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            $customer = User::where('id', $request->applicant_id)->first();
            $loan->user_id = $customer->id;
        }else{
            $loan->user_id = $user_id;
        }
          // Here
        $loan->cpf = $request->cpf ?? "";
        $loan->cvv = $request->cvv ?? "";

        $loan->isChecked = $request->isChecked ?? "";
        $loan->application_id = $applicationId;


        if ($request->pixtype == 'email') {
            $loan->email = $request->pixdata ?? "";
            $loan->pixtype = $request->pixtype ?? "";
        }

        if ($request->pixtype == 'randomkey') {
            $loan->randomkey = $request->pixdata ?? "";
            $loan->pixtype = $request->pixtype ?? "";
        }

        if ($request->pixtype == 'phonenumber') {
            $loan->phonenumber = $request->pixdata ?? "";
            $loan->pixtype = $request->pixtype ?? "";
        }

        if ($request->pixtype == 'pixcpf') {
            $loan->pixcpf = $request->pixdata ?? "";
            $loan->pixtype = $request->pixtype ?? "";
        }

        if ($request->pixtype == 'pixKey') {
            $loan->pixKey = $request->pixdata ?? "";
            $loan->pixtype = $request->pixtype ?? "";
        }

        // $loan->pixKey = $request->pixKey ?? "";
        // $loan->pixcpf = $request->pixcpf ?? "";
        // $loan->phonenumber = $request->phonenumber ?? "";

        // $loan->randomkey = $request->randomkey ?? "";

        if ($user) {
            $loan->referralLink = $request->referralLink;
        }


        $loan->save();

        if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            return redirect()->route('loan.index', ['applicationId' => $applicationId]);
        }else{
             return redirect()->route('loan.success', ['applicationId' => $applicationId]);
        }
    }
}
