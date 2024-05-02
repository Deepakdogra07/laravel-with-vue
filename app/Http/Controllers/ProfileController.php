<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Withdraw;
use App\Models\FooterData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $discountCode = User::where('id',Auth::user()->id)->first();
        $auth_type = Auth::user()->user_type;
        if($auth_type!=1){
            $footer_data = FooterData::first();
            return Inertia::render('Profile/EditUser', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
                'discountCode' => $discountCode,
                'auth_type' => $auth_type,
                'footer_data'=>$footer_data
            ]);
        }
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'discountCode' => $discountCode,
            'auth_type' => $auth_type,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function editProfile(Request $request)
    {
        $acountDetails = null;
        $userData = User::where('id',$request->user()->id)->first();
        // dd($userData->toArray());
        return Inertia::render('Frontend/Profile/Edit',['userData'=> $userData,'acountDetails'=>$acountDetails]);
    }

    public function updateUserProfile(Request $request){
        $userId = auth()->id();
        $isChecked = $request->input('isChecked');
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|confirmed|min:4',
            'phone' => 'required|digits:11',
            'pixtype' => $request->input('isChecked') == '0' ? 'required' : '',
            'pixdata' => $request->input('isChecked') == '0' ? 'required' : '',
            'bankcode' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
            'agencyNumber' => $request->input('isChecked') === '1' ? 'required|numeric|min:1' : '',
            'currentAccountNumber' => $request->input('isChecked') === '1' ? 'required|numeric|digits:14' : '',
            'cpf' => $request->input('isChecked') === '1' ? 'required' : '',
        ];



        if(isset($request->old_password) && $request->old_password != null){
            $rules['old_password'] = 'old_password';
        }



        if ($request->pixtype === 'phonenumber' && $request->input('isChecked') == '0') {
            $rules['pixdata'] = 'required|digits:11';
        }

        if ($request->pixtype === 'pixcpf' && $request->input('isChecked') == '0') {
            $rules['pixdata'] = 'required|numeric|digits:11';
        }

        if ($request->pixtype === 'eemail' && $request->input('isChecked') == '0') {
            $rules['pixdata'] = 'required|email:email';
        }



        $messages = [
            'pixdata.required' => 'Este campo é obrigatório.',
            'bankcode.required' => 'Este campo é obrigatório.',
            'bankcode.numeric' => 'O código do banco contém valor numérico.',
            'bankcode.min' => 'O código do banco deve ter pelo menos um dígito.',
            'agencyNumber.required' => 'o número da agência deve ser numérico',
            'currentAccountNumber.required' => 'Este campo é obrigatório.',
            'currentAccountNumber.digits' => 'current acount number must be 14 digit.',
            'cpf.required' => 'Este campo é obrigatório.',
            'name.required' => 'Este campo é obrigatório.',
            'email.required' => 'Este campo é obrigatório.',
            'email.email' => 'Por favor insira um endereço de e-mail válido.',
            'email.unique' => 'O endereço de e-mail já está em uso.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'address.required' => 'Este campo é obrigatório.',
            'phone.required' => 'Este campo é obrigatório.',
            'phone.digits' => 'O número de telefone deve ter exatamente 11 dígitos.',
            'old_password.required' => 'O campo de senha antiga é obrigatório.',
            'old_password.old_password' => 'A senha antiga está incorreta.',
            'account_details.required' => 'Este campo deve ser obrigatório',
            'account_details.numeric'=>'Deve conter apenas valor numérico',
            'account_details.gt' => 'O número da conta deve ser maior que 0',
            'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula, um dígito e um caractere especial.',
        ];

        $validatedData = $request->validate($rules, $messages);
        $user = User::find($request->id);

        // User::where('id',$request->id)->update([
        //     'name'=> $request->name,
        //     'email'=> $request->email,
        //     'password'  => Hash::make($request->password),
        //     'address' => $request->address,
        //     'phone' => $request->phone,

        // ]);

        if ($user) {
            $user->name = $request->name ?? '';
            $user->email = $request->email ?? " ";
            $user->password =Hash::make($request->password) ?? '';
            $user->address = $request->address ?? " ";
            $user->phone = $request->phone ?? " ";




            $user->pixtype = $request->pixtype ?? "";





            $user->isChecked = $request->isChecked ?? "";
            $user->receiveLoanThrough = $request->receiveLoanThrough ?? '';


            if($request->isChecked == 1){
                $user->bankcode = $request->bankcode ?? "";
                $user->agency_number = $request->agencyNumber ?? "";
                $user->account_number = $request->currentAccountNumber ?? "";
                $user->bank_cpf = $request->cpf ?? "";

                $user->cpf = '';
                $user->phonenumber = '';
                $user->through_email = '';
                $user->randomkey = '';
                
            }

            // $user->bankcode = $request->bankcode ?? "";
            // $user->agency_number = $request->agencyNumber ?? "";
            // $user->account_number = $request->currentAccountNumber ?? "";
            // $user->bank_cpf = $request->cpf ?? "";




            if($request->pixtype == 'pixcpf'){
                $user->cpf = $request->pixdata;
                $user->phonenumber = '';
                $user->through_email = '';
                $user->randomkey = '';

                $user->bankcode = '';
                $user->agency_number = '';
                $user->account_number = '';
                $user->bank_cpf = '';
          }

          if($request->pixtype == 'eemail'){
              $user->through_email = $request->pixdata;
              $user->phonenumber = '';
              $user->cpf ='';
              $user->randomkey = '';

                $user->bankcode = '';
                $user->agency_number = '';
                $user->account_number = '';
                $user->bank_cpf = '';
          }

          if($request->pixtype == 'randomkey'){
            $user->randomkey = $request->pixdata;
            $user->phonenumber = '';
            $user->cpf ='';
            $user->through_email = '';

                $user->bankcode = '';
                $user->agency_number = '';
                $user->account_number = '';
                $user->bank_cpf = '';
          }

          if($request->pixtype == 'phonenumber'){
            $user->phonenumber = $request->pixdata;
            $user->randomkey = '';
            $user->cpf ='';
            $user->through_email = '';

                $user->bankcode = '';
                $user->agency_number = '';
                $user->account_number = '';
                $user->bank_cpf = '';
          }


            $user->save();
        }







        // Withdraw::where('id',1)->update([
        //     'account_details' => $request->account_details,
        // ]);

        // return Redirect::to('user/own/profile');

    }

    public function userProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $userProfile = User::where('id',$userId)->first();
        return Inertia::render('Frontend/Profile/index',compact('userProfile'));
    }
}
