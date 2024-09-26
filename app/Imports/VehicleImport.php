<?php

namespace App\Imports;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleModelVariant;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehicleImport implements ToModel, WithHeadingRow
{
    protected $errors = [];
    protected $rowIndex = 1; // To keep track of the current row index

    public function model(array $row)
    {
        // Process each row
        $this->processRow($row);
        return null; // No need to return anything, we handle errors separately
    }

    protected function processRow(array $row)
    {
        // Increment the row index
        $currentRow = $this->rowIndex++;

        // Validation
        $validator = Validator::make($row, [
            'customer_id'           => 'required',
            'vehicle_category_id'   => 'required',
            'vehicle_no'            => 'required',
            'year'                  => 'required',
            'vehicle_brand_id'      => 'required',
            'vehicle_model_id'      => 'required',
            'vehicle_variant_id'    => 'required'
        ]);

        if ($validator->fails()) {
            $this->addError($currentRow, 'Validation errors', $validator->errors()->toArray());
            return;
        }

        $user = User::find($row['customer_id']);
        if (!$user || !$user->hasRole('Customer')) {
            $this->addError($currentRow, 'customer_id', ['The selected customer_id is invalid or does not have the customer role.']);
            return;
        }

        $vehicleCategory = VehicleCategory::find($row['vehicle_category_id']);
        if (!$vehicleCategory) {
            $this->addError($currentRow, 'vehicle_category_id', ['The selected category_id is invalid.']);
            return;
        }

        $vehicleBrand = VehicleBrand::where('id', $row['vehicle_brand_id'])
            ->where('category_id', $row['vehicle_category_id'])->first();
        if (!$vehicleBrand) {
            $this->addError($currentRow, 'vehicle_brand_id', ['The selected brand_id is invalid or does not belong to the specified category.']);
            return;
        }

        $vehicleModel = VehicleModel::where('id', $row['vehicle_model_id'])
            ->where('category_id', $row['vehicle_category_id'])
            ->where('brand_id', $row['vehicle_brand_id'])
            ->first();
        if (!$vehicleModel) {
            $this->addError($currentRow, 'vehicle_model_id', ['The selected model_id is invalid or does not belong to the specified category and brand.']);
            return;
        }

        $vehicleVariant = VehicleModelVariant::where('id', $row['vehicle_variant_id'])
            ->where('category_id', $row['vehicle_category_id'])
            ->where('brand_id', $row['vehicle_brand_id'])
            ->where('model_id', $row['vehicle_model_id'])
            ->first();
        if (!$vehicleVariant) {
            $this->addError($currentRow, 'vehicle_variant_id', ['The selected variant_id is invalid or does not belong to the specified category, brand, and model.']);
            return;
        }

        // Create the vehicle only if all validations pass
        Vehicle::create([
            'cus_id'            => $row['customer_id'],
            'category_id'       => $row['vehicle_category_id'],
            'brand_id'          => $row['vehicle_brand_id'],
            'model_id'          => $row['vehicle_model_id'],
            'varient_model_id'  => $row['vehicle_variant_id'],
            'vehicle_no'        => $row['vehicle_no'],
            'year'              => $row['year'],
            'color'             => $row['color'],
            'chasis_no'         => $row['chasis_no'],
            'engine_no'         => $row['engine_no'],
            'additional_details' => $row['additional_detail']
        ]);
    }

    protected function addError($row, $field, $messages)
    {
        // Ensure that messages is always an array
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        $this->errors[] = [
            'row' => $row,
            'field' => $field,
            'errors' => $messages,
        ];
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
