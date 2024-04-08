<?php

namespace App\Exports;

use App\Models\Withdraw;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportLoan implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Withdraw::select('receipt')->where('id', $this->id)->get();
    }

    public function headings(): array
    {
        return ['Loan Rejected Reason'];
    }
}
