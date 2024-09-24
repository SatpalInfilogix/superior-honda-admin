<?php

namespace App\Imports;

use App\Models\SalesProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class SaleImport implements ToModel, WithHeadingRow
{
    protected $errors = [];
    protected $rowNumber = 0;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $this->rowNumber++;
        $validator = Validator::make($row, [
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ], [
            'product_id.exists' => "Row {$this->rowNumber}: The selected product ID is invalid."
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row'    => $row,
                'errors' => $validator->errors()->toArray(),
            ];
            return null;
        }

        // Create the sales product record
        SalesProduct::create([
            'product_id' => $row['product_id'],
            'start_date' => $row['start_date'],
            'end_date'   => $row['end_date']
        ]);

        return null; 
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
    
}
