<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class ServiceImport implements ToModel, WithHeadingRow
{
    protected $errors = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'service_no'    => 'required',
            'name'          => 'required',
            // 'price' => 'required|numeric|min:0',
            'price'         => 'required'
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->toArray()
            ];
            return null;
        }

        $service_no = $row['service_no'];

        if (empty($service_no)) {
            return null;
        }

        $service = Service::where('service_no', $service_no)->first();
        $cleanPrice = preg_replace('/[^\d.]/', '', $row['price']);

        if ($service) {
            $service->update([
                'name' => $row['name'],
                'price' => $cleanPrice,
            ]);
        } else {
            Service::create([
                'service_no' => $row['service_no'],
                'name' => $row['name'],
                'price' => $cleanPrice,
            ]);
        }

        return null; 
    }

    /**
     * Get the errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
