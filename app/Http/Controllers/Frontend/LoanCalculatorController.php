<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Loan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\InterestCommission;
use App\Http\Controllers\Controller;


class LoanCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Frontend/LoanCalculator/index');
    }

    public function details(Request $request)
    {
        // dd($request->toArray());
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


        $amount = $request->input('amount');
        $interestRate = InterestCommission::where('id', 1)->first()->interest ?? 24;
        $interestRate = ($interestRate ? intval($interestRate) : 24) * 12;
        if( $interestRate == 0){
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
        ];




        return response()->json(['status' => true, 'data' => $data]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
