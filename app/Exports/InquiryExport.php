<?php

namespace App\Exports;

use App\Models\Inquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InquiryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Inquiry::select('id', 'name', 'date', 'email','vehicle','licence_no')->get(); // Select columns you want to export
    }

    public function headings(): array
    {
        return [
            'ID',     
            'Name', 
            'Date',    
            'Email',
            'Vehicle',
            'Licence Number'
        ];
    }
}

class CustomrInquiryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Inquiry::select('id', 'name', 'date', 'email','vehicle','licence_no')->get(); // Select columns you want to export
    }

    public function headings(): array
    {
        return [
            'ID',     
            'Name', 
            'Date',    
            'Email',
            'Vehicle',
            'Licence Number'
        ];
    }
}