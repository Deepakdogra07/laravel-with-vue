<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Loan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Withdraw;
use App\Mail\ReapplyLoan;
use App\Mail\WithdrawlMail;
use Illuminate\Support\Str;
use App\Mail\AutoAssignLoan;
use App\Mail\CreateLoanMail;
use Illuminate\Http\Request;
use Sabberworm\CSS\Value\URL;
use App\Models\ContactDetails;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Mail\UserRefralLinkMail;
use App\Models\InterestCommission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $loanRecord = Loan::where('user_id', $id)->where('is_deleted',0)->get();
        $auth_id = Auth::user()->id;
        $applied_loans = Loan::where('user_id', $auth_id)->get();
        $applied_loans_count = count($applied_loans);

        $applied_loans_approved = Loan::where('user_id', $auth_id)->where('status', 1)->get();
        $applied_loans_approved_count = count($applied_loans_approved);

        $applied_loans_rejected = Loan::where('user_id', $auth_id)->where('status', 2)->get();
        $applied_loans_rejected_count = count($applied_loans_rejected);

        foreach ($loanRecord as $loan) {
            $loan->carda = Storage::disk('public')->url('Loan Image/' . $loan->cardLimitScreenshot);
        }

        return Inertia::render('Frontend/Loan/index',
            [
                'loanRecord' => $loanRecord,
                'applied_loans_rejected_count' => $applied_loans_rejected_count,
                'applied_loans_count' => $applied_loans_count,
                'applied_loans_approved_count' => $applied_loans_approved_count,
                'applied_loans_approved' => $applied_loans_approved,
                'applied_loans_rejected' => $applied_loans_rejected,
            ]

        );
    }

    public function dashboardDesign()
    {

        $id = Auth::user()->id;
        $loanRecord = Loan::where('user_id', $id)->get();

        foreach ($loanRecord as $loan) {
            $loan->carda = Storage::disk('public')->url('Loan Image/' . $loan->cardLimitScreenshot);
        }

        return Inertia::render('Frontend/Loan/index1', ['loanRecord' => $loanRecord]);
    }
    public function create()
    {
        // $sessionData = Session::all();
        // $referralCode = $sessionData['refralcode'];
        // $referralCodeKey = 'referralcode';


        $sessionData = Session::all();
        if (array_key_exists('refralcode', $sessionData)) {
            $referralCode = $sessionData['refralcode'];
        } else {
            $referralCode = '';
        }


        if (array_key_exists('discountcode', $sessionData)) {
            $discountcode = $sessionData['discountcode'];

        } else {
            $discountcode = '';
        }
        // dd($discountcode);
        $discountcodevalue = DB::table('interest_commission')->where('id',1)->first()->discount ?? 0;

        $isUserLoggedIn = (bool) Auth::id();


        $interest_rate = InterestCommission::where('id', 1)->first()->interest ?? 24;
        return Inertia::render('Frontend/Loan/create', ['interest_rate' => $interest_rate,
        'referralCode'=>$referralCode,
        'discountcode'=> $discountcode,
        'discountcodevalue' => $discountcodevalue,
        'isUserLoggedIn' => $isUserLoggedIn
    ]);
    }

    public function store(Request $request)
    {
        // dd($request->loan_amount);
        $commission = DB::table('interest_commission')->latest()->first();
        // $commissionValue = $commission->commission ?? 0;
        $commissionValue = $commission->interest ?? 0;
        $rules = [
            'declarationCheckbox' => 'required|accepted',
            'loan_amount' => 'required|numeric|gt:0',
            'limitAvailable' => 'required|numeric|gt:0',
            'numberOfmonths' => 'required',
            'frontCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif',
            'backCardSelfie' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048576',
            'frontCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048576',
            'backCardImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048576',
            'cardLimitScreenshot' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048576',
            'cardNumber' => 'required|numeric|digits:16',
            'printedName' => 'required',
            'date' => ['required', 'after_or_equal:today'],
            'cvv' => 'required|digits:3|numeric',
            'password' => Auth::check() ? 'nullable' : 'required|min:4',

        ];

        if ($request->input('documentOption') === 'ssn') {
            $rules['ssnFrontPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:1048576';
            $rules['ssnBackPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:1048576';
        } elseif ($request->input('documentOption') === 'drivingLicense') {
            $rules['dlFrontPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:1048576';
            $rules['dlBackPhoto'] = 'required|image|mimes:jpeg,png,jpg,gif|max:1048576';
        }

        $rules['eemail'] = Auth::check() ? 'nullable|email' : 'required|email|unique:users,email';

        $rules['password'] = Auth::check() ? 'nullable' : 'required|min:4';

        $rules['phone_number'] = Auth::check() ? 'nullable' : 'required|min:11|gt:0|numeric';
        $rules['phone_number'] = Auth::check() ? 'nullable' : 'min:11';
        // here

        $customMessages = [
            'phone_number.required'=>'Este campo é obrigatório.',
            'phone_number.numeric'=>'O número de telefone deve ser numérico.',
            'phone_number.gt'=>'O número de telefone deve ser maior que 0.',
            'phone_number.min'=>'O número de telefone deve ter 11 dígitos numéricos.',
            'password.regex'=>'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um dígito e um caractere especial.',
            'eemail.required' => 'Este campo é obrigatório',
            'eemail.email' => 'Este campo deve ser do tipo e-mail.',
            'eemail.unique' => 'O e-mail deve ser exclusivo.',
            'password.required' => 'Este campo é obrigatório',
            'password.min' => 'A senha não deve ter pelo menos quatro dígitos.',
            'applicant_id.required' => 'Este campo é obrigatório',
            'printedName.required' => 'Este campo é obrigatório',
            'printedName.alpha' => 'O nome impresso deve conter apenas caracteres alfabéticos.',
            'cardNumber.required' => 'Este campo é obrigatório',
            'cardNumber.numeric' => 'O campo Número do cartão deve ser numaric',
            'cardNumber.digits' => 'O campo Número do cartão deve ter 16 dígitos numéricos',
            'date.required' => 'Este campo é obrigatório',
            'date.after_or_equal' => 'A data deve ser posterior ou igual a hoje.',
            'cvv.required' => 'Este campo é obrigatório',
            'cvv.digits' => 'Cvv deve ter três dígitos',
            'cvv.numeric' => 'Cvv deve ser numarico',
            'discount_code.in' => 'Código de desconto inválido.',
            'loan_amount.required' => 'Este campo é obrigatório.',
            'numberofinstallment.required' => 'Este campo é obrigatório.',
            'numberOfmonths.required' => 'Este campo é obrigatório.',
            'receiveLoanThrough.required' => 'Este campo é obrigatório.',
            'documentOption.required' => 'Este campo é obrigatório.',
            'limitAvailable.required' => 'Este campo é obrigatório.',
            'frontCardSelfie.required' => 'Faça upload de uma imagem selfie do cartão frontal.',
            'frontCardSelfie.image' => 'A selfie do cartão frontal deve ser uma imagem.',
            'frontCardSelfie.mimes' => 'A selfie do cartão frontal deve ser um arquivo de imagem válido (jpeg, png, jpg, gif).',
            'frontCardSelfie.max' => 'A selfie do cartão frontal não pode ser superior a 1 gb kilobytes.',

            'backCardSelfie.required' => 'Faça upload de uma imagem selfie do cartão traseiro.',
            'backCardSelfie.image' => 'A selfie do verso do cartão deve ser uma imagem.',
            'backCardSelfie.mimes' => 'A selfie do verso do cartão deve ser um arquivo de imagem válido (jpeg, png, jpg, gif).',
            'backCardSelfie.max' => 'A selfie do cartão traseiro não pode ser superior a 1 gb kilobytes.',

            'frontCardImage.required' => 'Faça upload de uma imagem frontal do cartão.',
            'frontCardImage.image' => 'A imagem frontal do cartão deve ser uma imagem.',
            'frontCardImage.mimes' => 'A imagem frontal do cartão deve ser um arquivo de imagem válido (jpeg, png, jpg, gif).',
            'frontCardImage.max' => 'A imagem frontal do cartão não pode ser superior a 1 gb kilobytes.',

            'backCardImage.required' => 'Por favor, carregue uma imagem do verso do cartão.',
            'backCardImage.image' => 'A imagem do verso do cartão deve ser uma imagem.',
            'backCardImage.mimes' => 'A imagem do verso do cartão deve ser um arquivo de imagem válido (jpeg, png, jpg, gif).',
            'backCardImage.max' => 'A imagem do verso do cartão não pode ser superior a 1 gb kilobytes.',

            'cardLimitScreenshot.required' => 'Faça upload de uma captura de tela do limite do cartão.',
            'cardLimitScreenshot.image' => 'A captura de tela do limite do cartão deve ser uma imagem.',
            'cardLimitScreenshot.mimes' => 'A captura de tela do limite do cartão deve ser um arquivo de imagem válido (jpeg, png, jpg, gif).',
            'cardLimitScreenshot.max' => 'The card limit screenshot may not be greater than 2048 kilobytes.',
            'declarationCheckbox.accepted' => 'Marque a caixa de seleção',
            'declarationCheckbox.required' => 'Marque a caixa de seleção',
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

        //   Yaha liya
        if (Auth::check() && Auth::user()->user_type !== null) {
            if ($request->has('referralLink') && $request->referralLink != null && Auth::user()->user_type == 3) {
                $exists = User::where('referralCode', $request->referralLink)->exists();
                if (!$exists) {
                    $error = true;
                    $validator->errors()->add('referralLink', "Este código de referência não existe!");
                }
            }
        }


        $discountcodeOfSuperAdmin = User::where('user_type', 1)->first()?->referralcode;

        // dd($discountcodeOfSuperAdmin , $request->discount_code);

        if (isset($request->discount_code) && $discountcodeOfSuperAdmin !== $request->discount_code && Auth::user()->user_type == 3) {
            $error = true;
            $validator->errors()->add('discount_code', "Este código de desconto não existe!");
        }


        if(Auth::user()){
            $allLoanRecordThisUser = Loan::where('user_id', Auth::user()->id)->get();

            $matchedLoanRecords = $allLoanRecordThisUser->filter(function ($loan) use ($discountcodeOfSuperAdmin) {
                return $loan->discount_code === $discountcodeOfSuperAdmin;
            });


            if ($matchedLoanRecords->isNotEmpty() && $request->discount_code != null && isset($request->discount_code)) {
                $error = true;
                $validator->errors()->add('discount_code', "Código de desconto já utilizado");
            }
        }






        if (!Auth::user()) {
            $referralCode = Str::random(10);
            $user = User::create([
                'name' => 'User',
                'email' => $request->eemail,
                'password' => Hash::make($request->password),
                'referralcode' => $referralCode,
                'user_type' => 3,
                'phone' => $request->phone_number,
                // Here add status
                'status' => 1,
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

        $walletComission = DB::table('interest_commission')->where('id',1)->first()->commission ?? 0;

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
                $loanAmount = $request->loan_amount;
                $userId = User::where('id',$assign_to)->first()->email;


                $mailData = [
                    'loanAmount' => $loanAmount,
                     'userId' => $userId,
                ];

                Mail::to($userId)->send(new AutoAssignLoan($mailData));
            }elseif($no_of_loans > $loans){
                $no_of_loans = $loans;
                $assign_to = $user->id;
                $loanAmount = $request->loan_amount;
                $userId = User::where('id',$assign_to)->first()->email;
                $mailData = [
                    'loanAmount' => $loanAmount,
                     'userId' => $userId,
                ];
                Mail::to($userId)->send(new AutoAssignLoan($mailData));
            }
        }



        $allData = session()->all();
        if(isset($allData['refralcode'])){
            $user_email = User::where('referralcode',$allData['refralcode'])->first()->email;
            $mailData = [
                'email' => Auth::user()->email,
                'loan_amount' => $request->loan_amount,
            ];

            Mail::to($user_email)->send(new UserRefralLinkMail($mailData));
        }

        if (Auth::user()) {
            $user_id = Auth::user()->id;
        }


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
        $loan->discount_code = $request->discount_code ?? "";
        $loan->bankcode = $request->bankcode ?? "";
        $loan->agencyNumber = $request->agencyNumber ?? "";
        $loan->assigned_to = $assign_to ?? "";
        $loan->commission = $commissionValue ?? "";


        $loan->wallet_commission = $walletComission ?? 0;

        $loan->cal_emi = $request->emi ?? 0;
        $loan->cal_total_interest = $request->total_interest ?? 0;
        $loan->cal_total_payment = $request->total_payment ?? 0;





        if(isset($request->discount_code)){
            $loan->discountcodevalue = $request->discountcodevalue;
        }else{
            $loan->discountcodevalue = 0;
        }





        // $assignedTo
        $loan->currentAccountNumber = $request->currentAccountNumber ?? "";

        if(isset($request->applicant_id)){
            $loan->user_id = $request->applicant_id;
        }

             if(Auth::user()){
                $loan->applicant_name = Auth::user()->name;
             }else{
                $loan->applicant_name = 'User';
             }

       if(Auth::user()){
         $loan->user_id = $user_id;
       }

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


        if ($user) {
            $loan->referralLink = $request->referralLink;
        }
        $loan->save();

        if (Session::has('refralcode')) {
            Session::forget('refralcode');
        }

        if (Session::has('discountcode')) {
            Session::forget('discountcode');
        }
        return redirect()->route('loan.success', ['applicationId' => $applicationId]);
    }

    public function success($applicationId)
    {

        return Inertia::render('Frontend/Loan/successfully')
            ->with('applicationId', $applicationId);

    }

    public function delete(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        $id = Auth::user()->id;

        $loanRecord = Loan::where('user_id', $id)->get();

        foreach ($loanRecord as $loan) {
            $loan->carda = Storage::disk('public')->url('Loan Image/' . $loan->cardLimitScreenshot);
        }

        return response()->json(['status' => true, 'data' => $loanRecord], 200);
    }

    public function edit(string $id)
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
        return Inertia::render('Frontend/Loan/edit', ['record' => $record]);
    }

    // public function update(Request $request, string $id)
    // {

    //     $rules = [
    //         'limitAvailable' => 'required|numeric|gt:0',
    //         'loan_amount' => 'required|numeric|gt:0',
    //         'numberOfmonths' => 'required',
    //         'cardNumber' => 'required|numeric|gte:0|digits:14',
    //         'printedName' => 'required|alpha',
    //         'date' => ['required', 'after_or_equal:today'],
    //         'cvv' => 'required|numeric|digits:3',

    //         'pixtype' => $request->input('isChecked') == '0' ? 'required' : '',
    //         'pixdata' => $request->input('isChecked') == '0' ? 'required' : '',
    //         'bankcode' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
    //         'agencyNumber' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
    //         'currentAccountNumber' => $request->input('isChecked') === '1' ? 'required|numeric|digits:14' : '',
    //         'cpf' => $request->input('isChecked') === '1' ? 'required' : '',

    //         'dlFrontPhoto' => $request->input('documentOption') === 'drivingLicense' ? 'required' : '',
    //         'dlBackPhoto' => $request->input('documentOption') === 'drivingLicense' ? 'required' : '',
    //         'ssnFrontPhoto' => $request->input('documentOption') === 'ssn' ? 'required' : '',
    //         'ssnBackPhoto' => $request->input('documentOption') === 'ssn' ? 'required' : '',
    //     ];

    //     $messages = [
    //         'limitAvailable.required' => 'Este campo é obrigatório.',
    //         'limitAvailable.numeric' => 'O limite disponível deve ser numérico',
    //         'limitAvailable.gt' => 'O limite disponível deve ser maior que 0.',
    //         'loan_amount.required' => 'Este campo é obrigatório.',
    //         'loan_amount.numeric' => 'O valor do empréstimo deve ser numérico.',
    //         'loan_amount.gt' => 'O valor do empréstimo deve ser maior que 0.',
    //         'numberOfmonths' => 'Este campo é obrigatório.',
    //         'cardNumber.required' => 'Este campo é obrigatório.',
    //         'cardNumber.numeric' => 'Número do cartão Deve ser numérico.',
    //         'cardNumber.gte' => 'Número do cartão Deve ser maior que 0.',
    //         'cardNumber.digits' => 'O NÚMERO DO CARTÃO Deve ser maior que 14 dígitos.',
    //         'printedName.required' => 'Este campo é obrigatório.',
    //         'printedName.alpha' => 'O Nome Impresso deve estar em ordem alfabética.',
    //         'date.required' => 'Este campo é obrigatório.',
    //         'date.after_or_equal' => 'A data deve ser posterior ou igual a hoje.',
    //         'cvv.required'=>'Este campo é obrigatório.',
    //         'cvv.numeric' => 'Cvv Deve ser numérico.',
    //         'cvv.digits' => 'Cvv deve ter três dígitos.',
    //         'pixtype.required' => 'Este campo é obrigatório.',
    //         'pixdata.required' => 'Este campo é obrigatório.',
    //         'bankcode.required' => 'Este campo é obrigatório.',
    //         'bankcode.numeric' => 'O código do banco deve ser numérico.',
    //         'agencyNumber.required' => 'O número da agência deve ser obrigatório.',
    //         'agencyNumber.numeric' => 'O número da agência deve ser numérico.',
    //         'currentAccountNumber.required' => 'Este campo é obrigatório.',
    //         'currentAccountNumber.numeric' => 'O AccountNumber atual deve ser numérico.',
    //         'currentAccountNumber.digits' => 'O AccountNumber atual deve ter 14 dígitos numéricos.',
    //         'cpf.required' => 'Este campo é obrigatório.',
    //         'dlFrontPhoto.required' => 'Este campo é obrigatório.',
    //         'dlBackPhoto.required' => 'Este campo é obrigatório.',
    //         'ssnFrontPhoto.required' => 'Este campo é obrigatório.',
    //         'ssnBackPhoto.required' => 'Este campo é obrigatório.',
    //     ];

    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     if ($request->hasFile('ssnFrontPhoto')) {
    //         $image = $request->file('ssnFrontPhoto');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $ssnFrontPhotoOriginalName = $name;
    //     }

    //     if ($request->hasFile('ssnBackPhoto')) {
    //         $image = $request->file('ssnBackPhoto');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $ssnBackPhotoOriginalName = $name;
    //     }

    //     if ($request->hasFile('dlFrontPhoto')) {
    //         $image = $request->file('dlFrontPhoto');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $dlFrontPhotoOriginalName = $name;
    //     }

    //     if ($request->hasFile('dlBackPhoto')) {
    //         $image = $request->file('dlBackPhoto');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $dlBackPhotoOriginalName = $name;
    //     }

    //     if ($request->hasFile('frontCardSelfie')) {
    //         $image = $request->file('frontCardSelfie');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $frontCardSelfieOriginalName = $name;
    //     }

    //     if ($request->hasFile('backCardSelfie')) {
    //         $image = $request->file('backCardSelfie');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $backCardSelfieOriginalName = $name;
    //     }

    //     if ($request->hasFile('frontCardImage')) {
    //         $image = $request->file('frontCardImage');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $frontCardImageOriginalName = $name;
    //     }

    //     if ($request->hasFile('backCardImage')) {
    //         $image = $request->file('backCardImage');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $backCardImageOriginalName = $name;
    //     }

    //     if ($request->hasFile('cardLimitScreenshot')) {
    //         $image = $request->file('cardLimitScreenshot');
    //         $name = 'public/Loan_documents/' . uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    //         Storage::disk('local')->put($name, file_get_contents($image));
    //         $cardLimitScreenshotOriginalName = $name;
    //     }

    //     $loan = Loan::find($id);

    //     if ($loan) {
    //         $loan->loan_amount = $request->loan_amount ?? '';
    //         $loan->numberofinstallment = $request->numberofinstallment ?? " ";
    //         $loan->numberOfmonths = $request->numberOfmonths ?? '';
    //         $loan->cardNumber = $request->cardNumber ?? "";
    //         $loan->printedName = $request->printedName ?? "";
    //         $loan->date = $request->date ?? "";
    //         $loan->pixKey = $request->pixKey ?? "";
    //         $loan->receiveLoanThrough = $request->receiveLoanThrough ?? '';
    //         $loan->documentOption = $request->documentOption ?? '';
    //         $loan->cvv = $request->cvv ?? "";
    //         $loan->isChecked = $request->isChecked ?? "";

    //         $loan->bank_cpf = $request->bankcode ?? "";
    //         $loan->agency_number = $request->agencyNumber ?? "";
    //         $loan->account_number = $request->currentAccountNumber ?? "";
    //         $loan->cvv = $request->cvv ?? "";



    //         $loan->pixtype = $request->pixtype ?? "";




    //         if($request->pixtype == 'pixcpf'){
    //               $loan->pixcpf = $request->pixdata;
    //               $loan->phonenumber = '';
    //               $loan->email ='';
    //               $loan->randomkey = '';
    //         }

    //         if($request->pixtype == 'email'){
    //             $loan->email = $request->pixdata;
    //             $loan->phonenumber = '';
    //             $loan->pixcpf ='';
    //             $loan->randomkey = '';
    //         }

    //         if($request->pixtype == 'randomkey'){
    //             $loan->randomkey = $request->pixdata;
    //             $loan->phonenumber = '';
    //             $loan->pixcpf ='';
    //             $loan->email = '';
    //         }

    //         if($request->pixtype == 'phonenumber'){
    //             $loan->phonenumber = $request->pixdata;
    //             $loan->randomkey = '';
    //             $loan->pixcpf ='';
    //             $loan->email = '';
    //         }


    //         if (isset($ssnFrontPhotoOriginalName)) {
    //             $loan->ssnFrontPhoto = $ssnFrontPhotoOriginalName;
    //         }

    //         if (isset($ssnBackPhotoOriginalName)) {
    //             $loan->ssnBackPhoto = $ssnBackPhotoOriginalName;
    //         }

    //         if (isset($dlFrontPhotoOriginalName)) {
    //             $loan->dlFrontPhoto = $dlFrontPhotoOriginalName;
    //         }

    //         if (isset($dlBackPhotoOriginalName)) {
    //             $loan->dlBackPhoto = $dlBackPhotoOriginalName;
    //         }

    //         if (isset($frontCardSelfieOriginalName)) {
    //             $loan->frontCardSelfie = $frontCardSelfieOriginalName;
    //         }

    //         if (isset($backCardSelfieOriginalName)) {
    //             $loan->backCardSelfie = $backCardSelfieOriginalName;
    //         }

    //         if (isset($frontCardImageOriginalName)) {
    //             $loan->frontCardImage = $frontCardImageOriginalName;
    //         }

    //         if (isset($backCardImageOriginalName)) {
    //             $loan->backCardImage = $backCardImageOriginalName;
    //         }

    //         if (isset($cardLimitScreenshotOriginalName)) {
    //             $loan->cardLimitScreenshot = $cardLimitScreenshotOriginalName;
    //         }

    //         $loan->limitAvailable = $request->limitAvailable;

    //         $loan->save();
    //     } else {
    //     }

    //     if(Auth::user()->user_type == 1){
    //         return Redirect::to('loan')->with('success', 'Mismatch Token XSCFASG ASGSgdsfg gasgesdeggsg');
    //     }else{
    //        return Redirect::to('user/loan')->with('success', 'Mismatch Token XSCFASG ASGSgdsfg gasgesdeggsg');
    //     }


    // }

    public function update(Request $request, string $id)
    {
        $rules = [
            'limitAvailable' => 'required|numeric|gt:0',
            'loan_amount' => 'required|numeric|gt:0',
            'numberOfmonths' => 'required',
            'cardNumber' => 'required|numeric|gte:0|digits:16',
            'printedName' => 'required',
            'date' => ['required', 'after_or_equal:today'],
            'cvv' => 'required|numeric|digits:3',




            'pixtype' => $request->input('isChecked') == '0' ? 'required' : '',
            'pixdata' => $request->input('isChecked') == '0' ? 'required' : '',



            'bankcode' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
            'agencyNumber' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
            'currentAccountNumber' => $request->input('isChecked') === '1' ? 'required|numeric|digits:14' : '',
            'cpf' => $request->input('isChecked') === '1' ? 'required' : '',

            'dlFrontPhoto' => $request->input('documentOption') === 'drivingLicense' ? 'required' : '',
            'dlBackPhoto' => $request->input('documentOption') === 'drivingLicense' ? 'required' : '',
            'ssnFrontPhoto' => $request->input('documentOption') === 'ssn' ? 'required' : '',
            'ssnBackPhoto' => $request->input('documentOption') === 'ssn' ? 'required' : '',
        ];

        if ($request->input('pixtype') == 'pixcpf') {
            $rules['pixdata'] = 'required|digits:11';
        } elseif ($request->input('pixtype') == 'email') {
            $rules['pixdata'] = 'required|email';
        } elseif ($request->input('pixtype') == 'phonenumber') {
            $rules['pixdata'] = 'required|digits:11';
        } elseif ($request->input('pixtype') == 'randomkey') {
            $rules['pixdata'] = 'required';
        }

        $messages = [
            // 'loan_amount.required' => 'Este campo é obrigatório.',
            // 'numberofinstallment.required' => 'Este campo é obrigatório.',
            // 'numberOfmonths.required' => 'Este campo é obrigatório.',
            // 'limitAvailable.required' => 'Este campo é obrigatório.',
            // 'receiveLoanThrough.required' => 'É necessário pelo menos um dos métodos de pagamento.',

            'pixdata.required' => 'The PIX data field is required.',
            'pixdata.digits' => 'This field must be :digits digits.',
            'pixdata.email' => 'This field must be a valid email address.',



            'limitAvailable.required' => 'Este campo é obrigatório.',
            'limitAvailable.numeric' => 'O limite disponível deve ser numérico',
            'limitAvailable.gt' => 'O limite disponível deve ser maior que 0.',
            'loan_amount.required' => 'Este campo é obrigatório.',
            'loan_amount.numeric' => 'O valor do empréstimo deve ser numérico.',
            'loan_amount.gt' => 'O valor do empréstimo deve ser maior que 0.',
            'numberOfmonths' => 'Este campo é obrigatório.',
            'cardNumber.required' => 'Este campo é obrigatório.',
            'cardNumber.numeric' => 'Número do cartão Deve ser numérico.',
            'cardNumber.gte' => 'Número do cartão Deve ser maior que 0.',
            'cardNumber.digits' => 'O NÚMERO DO CARTÃO Deve ser maior que 16 dígitos.',
            'printedName.required' => 'Este campo é obrigatório.',
            'printedName.alpha' => 'O Nome Impresso deve estar em ordem alfabética.',
            'date.required' => 'Este campo é obrigatório.',
            'date.after_or_equal' => 'A data deve ser posterior ou igual a hoje.',
            'cvv.required'=>'Este campo é obrigatório.',
            'cvv.numeric' => 'Cvv Deve ser numérico.',
            'cvv.digits' => 'Cvv deve ter três dígitos.',
            'pixtype.required' => 'Este campo é obrigatório.',
            'pixdata.required' => 'Este campo é obrigatório.',
            'bankcode.required' => 'Este campo é obrigatório.',
            'bankcode.numeric' => 'O código do banco deve ser numérico.',
            'agencyNumber.required' => 'O número da agência deve ser obrigatório.',
            'agencyNumber.numeric' => 'O número da agência deve ser numérico.',
            'currentAccountNumber.required' => 'Este campo é obrigatório.',
            'currentAccountNumber.numeric' => 'O AccountNumber atual deve ser numérico.',
            'currentAccountNumber.digits' => 'O AccountNumber atual deve ter 14 dígitos numéricos.',
            'cpf.required' => 'Este campo é obrigatório.',
            'dlFrontPhoto.required' => 'Este campo é obrigatório.',
            'dlBackPhoto.required' => 'Este campo é obrigatório.',
            'ssnFrontPhoto.required' => 'Este campo é obrigatório.',
            'ssnBackPhoto.required' => 'Este campo é obrigatório.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

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

        $loan = Loan::find($id);

        if ($loan) {
            $loan->loan_amount = $request->loan_amount ?? '';
            $loan->numberofinstallment = $request->numberofinstallment ?? " ";
            $loan->numberOfmonths = $request->numberOfmonths ?? '';
            $loan->cardNumber = $request->cardNumber ?? "";
            $loan->printedName = $request->printedName ?? "";
            $loan->date = $request->date ?? "";
            $loan->pixKey = $request->pixKey ?? "";
            $loan->receiveLoanThrough = $request->receiveLoanThrough ?? '';
            $loan->documentOption = $request->documentOption ?? '';
            $loan->cvv = $request->cvv ?? "";
            $loan->isChecked = $request->isChecked ?? "";

            $loan->bankcode = $request->bankcode ?? "";
            $loan->agencyNumber = $request->agencyNumber ?? "";
            $loan->currentAccountNumber = $request->currentAccountNumber ?? "";
            // $loan->cpf = $request->cpf ?? "";
            $loan->cvv = $request->cvv ?? "";

            // dd($request->pixcpf);

            $loan->pixtype = $request->pixtype ?? "";


            // $request->pixtype = $request->pixtype ?? "";

            if($request->pixtype == 'pixcpf'){
                  $loan->pixcpf = $request->pixdata;
                  $loan->phonenumber = '';
                  $loan->email ='';
                  $loan->randomkey = '';
            }

            if($request->pixtype == 'email'){
                $loan->email = $request->pixdata;
                $loan->phonenumber = '';
                $loan->pixcpf ='';
                $loan->randomkey = '';
            }

            if($request->pixtype == 'randomkey'){
                $loan->randomkey = $request->pixdata;
                $loan->phonenumber = '';
                $loan->pixcpf ='';
                $loan->email = '';
            }

            if($request->pixtype == 'phonenumber'){
                $loan->phonenumber = $request->pixdata;
                $loan->randomkey = '';
                $loan->pixcpf ='';
                $loan->email = '';
            }

            // if(isset($request->phonenumber)){
            //     $loan->phonenumber = $request->phonenumber;
            // }else{
            //     $loan->pixcpf = '';
            //     $loan->email ='';
            //     $loan->randomkey = '';
            // }


            // if(isset($request->email)){
            //     $loan->email = $request->email;
            // }else{
            //     $loan->pixcpf = '';
            //     $loan->phonenumber ='';
            //     $loan->randomkey = '';
            // }

            // if(isset($request->randomkey)){
            //     $loan->randomkey = $request->randomkey;
            // }else{
            //     $loan->pixcpf = '';
            //     $loan->phonenumber ='';
            //     $loan->email = '';
            // }










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
            // Handle the case where the record with the given ID is not found
            // You may want to return a response or perform other actions.
        }

        if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
            return Redirect::to('loan')->with('success', 'Mismatch Token XSCFASG ASGSgdsfg gasgesdeggsg');
        }else{
            return Redirect::to('user/loan')->with('success', 'Mismatch Token XSCFASG ASGSgdsfg gasgesdeggsg');
        }


    }

    public function loanValue(Request $request, $id)
    {
        $my_refferal_code = Auth::user()->referralcode;
        $loans = Loan::where('referralLink', $my_refferal_code)->with('user')->distinct('user_id')->get();

        // dd($loans);
        $statusCounts = [
            'status_0' => 0,
            'status_1' => 0,
            'status_2' => 0,
        ];

        foreach ($loans as $loan) {
            switch ($loan->status) {
                case 0:
                    $statusCounts['status_0']++;
                    break;
                case 1:
                    $statusCounts['status_1']++;
                    break;
                case 2:
                    $statusCounts['status_2']++;
                    break;
            }
        }



        $pendingRecord = $statusCounts['status_0'];
        $approvedRecord = $statusCounts['status_1'];
        $rejectedRecord = $statusCounts['status_2'];

        return response()->json([
            'status' => true,
            'data' => $loans,
            'pending' => $pendingRecord,
            'approved' => $approvedRecord,
            'rejected' => $rejectedRecord,
        ]);

    }

    public function affiliate()
    {
        $users = User::all();
        $auth_id = Auth::user()->id;
        $applied_loans = Loan::where('user_id', $auth_id)->get();
        $applied_loans_count = count($applied_loans);

        $applied_loans_approved = Loan::where('user_id', $auth_id)->where('status', 1)->get();
        $applied_loans_approved_count = count($applied_loans_approved);

        $applied_loans_rejected = Loan::where('user_id', $auth_id)->where('status', 2)->get();
        $applied_loans_rejected_count = count($applied_loans_rejected);

        $my_refferal_code = Auth::user()->referralcode;


        $loans = Loan::where('referralLink', $my_refferal_code)->whereIn('status', [1,4,6])->with('user')->distinct('user_id')->get();



        $totalAmount = 0;
        foreach ($loans as $loan) {
            // $commission = $loan->commission;
            $commission = $loan->wallet_commission;
            $amount = ($loan->loan_amount * $commission) / 100;
            $totalAmount += $amount;
        }


        $withdrawals = Withdraw::where('status', 1)->where('user_id', $auth_id)->get();

        $allWithdrawalAmountSum = 0;
            foreach ($withdrawals as $withdrawal) {
                $withdrawAmount = $withdrawal->withdrawAmount;
                $allWithdrawalAmountSum += $withdrawAmount;
            }

        // foreach ($withdrawals as $withdrawal) {
        //     $userId = $withdrawal->user_id;
        //     $withdrawAmount = $withdrawal->withdrawAmount;
        //     $totalAmount += $withdrawAmount;
        //     $withdrawal->update(['status' => 1]);
        // }

        $commission = DB::table('interest_commission')->where('id',1)->first();
        // $totalcommission = $commission->commission;
        $totalcommission = isset($commission->commission) ? $commission->commission : 0;

        $totalCom = floatval($totalcommission);


        $amount = $totalAmount - $allWithdrawalAmountSum;
        $auth_user = Auth::user()->user_type;
        // dd($auth_user);
        return Inertia::render('Frontend/Loan/affiliate',
            [
                'users' => $users,
                'amount' => $amount,
                'my_refferal_code' => $my_refferal_code,
                'applied_loans_count' => $applied_loans_count,
                'applied_loans_approved_count' => $applied_loans_approved_count,
                'applied_loans_rejected_count' => $applied_loans_rejected_count,
                'totalCom' => $totalCom,
                'auth_user' => $auth_user,
            ]

        );
    }

    public function referralManagement()
    {
        $auth_id = Auth::user()->id;
        $applied_loans = Loan::where('user_id', $auth_id)->get();
        $applied_loans_count = count($applied_loans);

        $applied_loans_approved = Loan::where('user_id', $auth_id)->where('status', 1)->get();
        $applied_loans_approved_count = count($applied_loans_approved);

        $applied_loans_rejected = Loan::where('user_id', $auth_id)->where('status', 2)->get();
        $applied_loans_rejected_count = count($applied_loans_rejected);


        $commission = DB::table('interest_commission')->where('id',1)->first();

        $totalcommission = isset($commission->commission) ? $commission->commission : 0;
        $totalCom = floatval($totalcommission);


        $my_refferal_code = Auth::user()->referralcode;
        $loans = Loan::where('referralLink', $my_refferal_code)->whereIn('status', [1,4,6])->with('user')->distinct('user_id')->get();

        $totalAmount = 0;
        foreach ($loans as $loan) {
            $commission = $loan->wallet_commission;
            $amount = ($loan->loan_amount * $commission) / 100;
            $totalAmount += $amount;
        }

            $thirtyDaysAgo = Carbon::now()->subDays(30)->toDateString();
            $my_refferal_codes = Auth::user()->referralcode;
            $loanss = Loan::where('referralLink', $my_refferal_codes)
            ->whereIn('status', [1, 4, 6])
            ->whereDate('created_at', '<=', $thirtyDaysAgo)
            ->with('user')
            ->distinct('user_id')
            ->get();

             $thirtyDaysOldAmount = 0;

            foreach ($loanss as $loan) {
                $commissions = $loan->wallet_commission;
                $amounts = ($loan->loan_amount * $commissions) / 100;
                $thirtyDaysOldAmount += $amounts;
            }

            $thirtyDaysNotComplete = Carbon::now()->subDays(30)->toDateString();
            $my_refferal_codes = Auth::user()->referralcode;
            $loanssRecord = Loan::where('referralLink', $my_refferal_codes)
            ->whereIn('status', [1, 4, 6])
            ->whereDate('created_at', '>', $thirtyDaysNotComplete)
            ->with('user')
            ->distinct('user_id')
            ->get();

             $NotthirtyDaysOldAmounts = 0;

            foreach ($loanssRecord as $loan) {
                $commissions = $loan->wallet_commission;
                $amounts = ($loan->loan_amount * $commissions) / 100;
                $NotthirtyDaysOldAmounts += $amounts;
            }

        $withdrawals = Withdraw::where('status', 1)->where('user_id', $auth_id)->get();


        $allWithdrawalAmountSum = 0;
            foreach ($withdrawals as $withdrawal) {
                $withdrawAmount = $withdrawal->withdrawAmount;
                $allWithdrawalAmountSum += $withdrawAmount;
            }

            // dd($allWithdrawalAmountSum);

        $amount = $totalAmount - $allWithdrawalAmountSum;
        $thirtyDaysOldAmounts = $thirtyDaysOldAmount - $allWithdrawalAmountSum;


        $withdrawl = Withdraw::where('user_id', Auth::user()->id)->get();
        $userDetails = User::where('id',Auth()->user()->id)->first();
        return Inertia::render('Frontend/Loan/referralmanagement', [
            'amount' => $amount,
            'my_refferal_code' => $my_refferal_code,
            'applied_loans_count' => $applied_loans_count,
            'applied_loans_approved_count' => $applied_loans_approved_count,
            'applied_loans_rejected_count' => $applied_loans_rejected_count,
            'withdrawl' => $withdrawl,
            'userDetails' => $userDetails,
            'thirtyDaysOldAmounts'=>$thirtyDaysOldAmounts,
            'NotthirtyDaysOldAmounts' => $NotthirtyDaysOldAmounts,
        ]);
    }

    public function withdrawAmount(Request $request)
    {
        $rules = [
            'totalAmount' => 'required',
            'withdrawAmount' => 'required|numeric',
        ];

        $auth_user = Auth::user();

        if (($auth_user->cpf == null || $auth_user->cpf == '')
         && ($auth_user->phonenumber == null || $auth_user->phonenumber == '')
         && ($auth_user->through_email == null || $auth_user->through_email == '')
         && ($auth_user->randomkey == null ||  $auth_user->randomkey == '')
         && ($auth_user->bankcode = null  || $auth_user->bankcode == '')
         ) {
            $rules['cpf_or_phone'] = 'required';
        }

        $messages = [
            'cpf_or_phone.required' => 'Por favor, preencha os detalhes da sua conta em editar perfil.',
            'totalAmount.required' => 'Este campo é obrigatório.',
            'withdrawAmount.required' => 'Este campo é obrigatório.',
            'account_details.required' => 'Este campo é obrigatório.',
            'withdrawAmount.numeric' => 'Deve ser numérico',
            'account_details.numeric' => 'Deve ser numérico.',
            'account_details.gte' => 'Deve ser maior que 0',
            'cpf.exists' => 'O CPF não existe em nossos registros.',
            'at_least_one_exists' => 'Pelo menos um CPF, número de telefone, e-mail, chave aleatória ou código do banco deve existir em nossos registros.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $totalAmount = $request->totalAmount;
        $withdrawAmount = $request->withdrawAmount;
        $thirtyDaysOldAmounts = $request->thirtyDaysOldAmounts;

        $errors = false;

        // if($thirtyDaysOldAmounts <= intval($withdrawAmount) ){
        //     $errors = true;
        //     $validator->errors()->add('withdrawAmount', 'O valor da retirada deve ser inferior ao Valor de Recuperação.');
        // }

        $totalAmountRequest = Withdraw::where('user_id', Auth::user()->id)->where('status', '!=', 2)->get();



        $totalwithdrawlRequest = 0;

        for ($i = 0; $i < count($totalAmountRequest); $i++) {
            $totalwithdrawlRequest += $totalAmountRequest[$i]['withdrawAmount'];
        }

        // dd($totalwithdrawlRequest);   0
        // dd($thirtyDaysOldAmounts);  5000


        //  Here
        $sendingRequest = $thirtyDaysOldAmounts - $totalwithdrawlRequest;

        // dd($sendingRequest);   5000

        if ( $sendingRequest <= intval($withdrawAmount)) {
            $errors = true;
            $validator->errors()->add('withdrawAmount', 'Você pode sacar valores de até R$ ' . $sendingRequest . '. Porque algum pedido você já envia.');
        }



        // if ($thirtyDaysOldAmounts <= intval($withdrawAmount)) {
        //     dd("Hello!");
        //     $errors = true;
        //     $validator->errors()->add('withdrawAmount', 'Você pode sacar valores de até R$ ' . $sendingRequest . '. Porque algum pedido você já envia.');
        // }

        if ($totalAmount < $withdrawAmount) {
            $errors = true;
            $validator->errors()->add('withdrawAmount', 'O valor total deve ser maior que o valor retirado.');
        }

        if ($withdrawAmount < 200) {
            $errors = true;
            $validator->errors()->add('withdrawAmount', 'O valor sacado deve ser superior a 200.');
        }



        // $totalAmountRequest = Withdraw::where('user_id', Auth::user()->id)->where('status', '!=', 2)->get();



        // $totalwithdrawlRequest = 0;

        // for ($i = 0; $i < count($totalAmountRequest); $i++) {
        //     $totalwithdrawlRequest += $totalAmountRequest[$i]['withdrawAmount'];
        // }

        if (($totalwithdrawlRequest + $request->withdrawAmount) > $totalAmount) {
            $errors = true;
            $validator->errors()->add('withdrawAmount', 'O valor da solicitação de saque não é superior ao valor total');
        }


        if ($errors) {
            return back()->withErrors($validator->errors());
        }

        $userId = Auth::user()->id;
        $userData = User::where('id',$userId)->first();


        $superAdminEmail = User::where('id',1)->first()->email;
        $auth_user_email = Auth::user()->email;

            // $mailData = [
            //     'title' => 'Mail from ItSolutionStuff.com',
            //     'body' =>  $request->withdrawAmount,
            // ];

       $withdrawAmount = $request->withdrawAmount;

       Mail::to($superAdminEmail)->send(new WithdrawlMail($withdrawAmount));

        Withdraw::create([
            'totalAmount' => $request->totalAmount,
            'withdrawAmount' => $request->withdrawAmount,
            'status' => 0,
            'user_id' => $userId,
            'account_details' => $request->account_details ?? "",
             'bankcode'=>$userData->bankcode ?? "",
             'agency_number'=>$userData->agency_number ?? "",
             'account_number' => $userData->account_number ?? "",
             'bank_cpf' => $userData->bank_cpf ?? "",
             'cpf' => $userData->cpf ?? "",
             'phonenumber'=>$userData->phonenumber,
             'through_email'=>$userData->through_email,
             'randomkey'=>$userData->randomkey,
             'pixtype'=>$userData->pixtype,
             'isChecked'=>$userData->isChecked,
             'receiveLoanThrough'=>$userData->receiveLoanThrough,
        ]);

        return to_route('referral.management');

    }

    public function loanViewPage($id)
    {
        $userRecord = Loan::where(['id' => $id, 'is_deleted' => 0])->first();
        $userRecord->cardLimitScreenshotImage = Storage::disk('local')->url($userRecord->cardLimitScreenshot);
        $userRecord->dlFrontPhoto = $userRecord->dlFrontPhoto ? Storage::disk('local')->url($userRecord->dlFrontPhoto) : null;
        $userRecord->dlBackPhoto = $userRecord->dlBackPhoto ? Storage::disk('local')->url($userRecord->dlBackPhoto) : null;
        $userRecord->frontCardSelfie = Storage::disk('local')->url($userRecord->frontCardSelfie);
        $userRecord->backCardSelfie = Storage::disk('local')->url($userRecord->backCardSelfie);
        $userRecord->frontCardImage = Storage::disk('local')->url($userRecord->frontCardImage);
        $userRecord->backCardImage = Storage::disk('local')->url($userRecord->backCardImage);
        $userRecord->ssnFrontPhoto = $userRecord->ssnFrontPhoto ? Storage::disk('local')->url($userRecord->ssnFrontPhoto) : null;
        $userRecord->ssnBackPhoto = $userRecord->ssnBackPhoto ? Storage::disk('local')->url($userRecord->ssnBackPhoto) : null;


        $userRecord->loan_complete_proof = Storage::disk('local')->url($userRecord->loan_complete_proof);

        // dd($userRecord->loan_complete_proof);




        $incompleteLoan = Loan::where('id', $id)->select('incompletereson')->first();
        $incompleteLoanReason = $incompleteLoan->incompletereson;
        // dd($incompleteLoanReason->incompletereson);


        return Inertia::render('Frontend/Loan/view', ['userRecord' => $userRecord, 'incompleteLoanReason' => $incompleteLoanReason]);
    }

    public function reapplyLoan(Request $request, $id)
    {
        $mailData = [
            'title' => Auth::user()->email,
            'name' => Auth::user()->name,
            'body' => 'This is Requesting for reaply the Loan',
        ];

        $superAdmin = User::where('user_type',1)->first();


        Mail::to(Auth::user()->email)->send(new ReapplyLoan($mailData));

        Mail::to($superAdmin->email)->send(new ReapplyLoan($mailData));

        Loan::where('id', $id)->update([
            'status' => 5,
        ]);

        // return to_route('all.loans');
    }

    public function userDashboard(Request $request)
    {
        $auth_id = Auth::user()->id;
        $applied_loans = Loan::where('user_id', $auth_id)->get();
        $applied_loans_count = count($applied_loans);

        $applied_loans_approved = Loan::where('user_id', $auth_id)->where('status', 1)->get();
        $applied_loans_approved_count = count($applied_loans_approved);

        $applied_loans_rejected = Loan::where('user_id', $auth_id)->where('status', 2)->get();
        $applied_loans_rejected_count = count($applied_loans_rejected);

        return Inertia::render('Frontend/Dashboard/index', ['applied_loans_rejected_count' => $applied_loans_rejected_count, 'applied_loans_count' => $applied_loans_count, 'applied_loans_approved_count' => $applied_loans_approved_count, 'applied_loans_approved' => $applied_loans_approved, 'applied_loans_rejected' => $applied_loans_rejected]);
    }
    public function instruction()
    {
        return Inertia::render('Frontend/Instruction/index');
    }

    public function withdrawListing(Request $request)
    {
        $withdrawl = Withdraw::where('user_id', Auth::user()->id)->get();
        return Inertia::render('Frontend/Instruction/withdrawlList', ['withdrawl' => $withdrawl]);
    }
    public function rejectLoanReason($id)
    {
        $withdraw = Withdraw::find($id);

        $data = [
            'receipt' => $withdraw->receipt,
        ];

        try {
            $pdf = PDF::loadView('loanRejectReason', $data);
            return $pdf->download('loanRejectReason.pdf');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getFooterData()
    {
        $contactDetails = ContactDetails::where('id', 1)->select('facebookurl', 'twitterurl', 'instagramurl')->first();
        return response()->json($contactDetails);
    }

    public function allLoans()
    {
        $id = Auth::user()->id;

        $loanRecord = Loan::where('user_id', $id)
            ->get();

        $countLoan = count($loanRecord);
        return Inertia::render('Frontend/Loan/all-loans', ['loanRecord' => $loanRecord, 'countLoan' => $countLoan]);
    }



    public function getAcountNumber(Request $request)
    {
        $allRecordFromWithdrawlTable = Withdraw::where('user_id', Auth::user()->id)->first();
        // dd($allRecordFromWithdrawlTable);
        return response()->json($allRecordFromWithdrawlTable);
    }

    public function loanViewDetails(Request $request)
    {

            $rules = [
                'amount' => 'required|numeric|gte:200|lte:50000',
                'loan_period' => 'required|numeric|gte:1|lt:13',
            ];

            $messages = [
                'amount.required' => 'Este campo é obrigatório.',
                'amount.numeric' => 'The amount field is must be a number.',
                'interest_rate.required' => 'Este campo é obrigatório.',
                'interest_rate.numeric' => 'The interest rate field is must be a number',
                'loan_period.required' => 'Este campo é obrigatório.',
                'loan_period.numeric' => 'O campo do período do empréstimo deve ser um número',
                'loan_period.gt' => 'O período do empréstimo deve ser de um ano ou superior a um ano.',
                'loan_period.lt' => 'O período do empréstimo deve ser menor ou igual a dez anos.',
                'amount.gte' => 'O campo Valor deve ser maior ou igual a ₹200,00',
                'amount.lte' => 'TO campo Valor deve ser menor ou igual a ₹ 50.000,00',
            ];

            $validatedData = $request->validate($rules, $messages);



            if($request->id['discountcodevalue'] == 0){
                $amount = $request->input('amount');
                $interestRate = InterestCommission::where('id', 1)->first()->interest ?? 24;
                $interestRate = ($interestRate ? intval($interestRate) : 24) * 12;

                // dd($interestRate);
                if($interestRate == 0){
                    $interestRate = 0.0001;
                }
                $loanPeriod = $request->input('loan_period');

                $interestRateMonthly = $interestRate / 100 / 12;
                $monthsInYear = 12;


                $emi = ($amount * $interestRateMonthly * pow(1 + $interestRateMonthly, $loanPeriod)) / (pow(1 + $interestRateMonthly, $loanPeriod) - 1);


                $totalInterest = ($emi * $loanPeriod) - $amount;
                $totalPayment = $emi * $loanPeriod;

                $data = [
                    'amount' => $amount,
                    'emi' => round($emi),
                    'total_interest' => round($totalInterest),
                    'total_payment' => round($totalPayment),
                    'interest_rate' => $interestRate,
                    'discount_value' => 0,
                ];

                return response()->json(['status' => true, 'data' => $data]);
            }else{
                //     $amount = $request->input('amount');
                //     $interestRate = InterestCommission::where('id', 1)->first()->interest ?? 24;
                //     $interestRates = ($interestRate ? intval($interestRate) : 24) * 12;

                //     $loanPeriod = intval($request->input('loan_period'));

                //     $interestRateMonthly = $interestRates / 100 / 12;
                //     if ($interestRateMonthly == 0) {
                //         $interestRateMonthly = 0.0000000001;
                //     }
                //     $emi = ($amount * $interestRateMonthly * pow(1 + $interestRateMonthly, $loanPeriod)) / (pow(1 + $interestRateMonthly, $loanPeriod) - 1);
                //     $totalInterest = ($emi * $loanPeriod) - $amount;


                //     $discountPercentage = intval(DB::table('interest_commission')->where('id',1)->first()->discount);


                //     $discountValue = $totalInterest * ($discountPercentage / 100);

                //     $interestRate = $interestRates - ($discountPercentage * 12);

                //     $totalPayment = $emi * $loanPeriod;

                //     $data = [
                //         'amount' => $amount,
                //         'emi' => round($emi),
                //         'total_interest' => round($totalInterest),
                //         'total_payment' => round($totalPayment),
                //         'interest_rate' => $interestRate,
                //         'discount_value' => $discountValue,
                //     ];

                // return response()->json(['status' => true, 'data' => $data]);


                $amount = $request->input('amount');
                $interestRate = InterestCommission::where('id', 1)->first()->interest ?? 24;
                $interestRates = ($interestRate ? intval($interestRate) : 24) * 12;

                $loanPeriod = intval($request->input('loan_period'));

                $interestRateMonthly = $interestRates / 100 / 12;
                if ($interestRateMonthly == 0) {
                    $interestRateMonthly = 0.0000000001;
                }
                $emi = ($amount * $interestRateMonthly * pow(1 + $interestRateMonthly, $loanPeriod)) / (pow(1 + $interestRateMonthly, $loanPeriod) - 1);
                $totalInterest = ($emi * $loanPeriod) - $amount;

                $discountPercentage = intval(DB::table('interest_commission')->where('id',1)->first()->discount);
                $discountValue = $totalInterest * ($discountPercentage / 100);

                // dd($discountValue);   2848
                // dd($totalInterest);   18988
                //  dd($discountPercentage);  15

                // Subtract discount from total interest
                // $totalInterest -= $discountValue;

                $interestRate = $interestRates - ($discountPercentage * 12);

                $totalPayment = $emi * $loanPeriod;

                // Calculate total payment after discount
                $totalPayment -= $discountValue;

                // Recalculate EMI based on modified total payment
                $emi = $totalPayment / $loanPeriod;

                $data = [
                    'amount' => $amount,
                    'emi' => round($emi),
                    'total_interest' => round($totalInterest),
                    'total_payment' => round($totalPayment),
                    'interest_rate' => $interestRate,
                    'discount_value' => $discountValue,
                ];

                return response()->json(['status' => true, 'data' => $data]);


            }



    }


    public function loginUserName()
    {
        $authUser = Auth::user()->name;
        $firstLetter = strtoupper(substr($authUser, 0, 1));
        return response()->json($firstLetter);
    }

}
