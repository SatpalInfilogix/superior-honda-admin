<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class VehicleImport implements ToModel, WithHeadingRow
{
    protected $errors = [];

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'service_no'    => 'required',
            'name'          => 'required',
            'price'         => 'required'
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->toArray()
            ];
            return null;
        }

        Service::create([
            'service_no' => $row['service_no'],
            'name' => $row['name'],
            'price' => $cleanPrice,
        ]);

        return null; 
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
