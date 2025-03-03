<?php

namespace App\Exports;

use App\Models\CustomerInquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerInquiryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CustomerInquiry::select('id', 'customer_name', 'customer_email', 'customer_inquiry_category','inquiry_status','inquiry_created_at')->get(); // Select columns you want to export
    }

    public function headings(): array
    {
        return [
            'ID',     
            'Customer Name',     
            'Customer Email',
            'Inquiry Category',
            'Inquiry Status',
            'Inquiry Created'
        ];
    }
}