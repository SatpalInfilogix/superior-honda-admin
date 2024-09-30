<?php

namespace App\Imports;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

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
        $currentRow = $this->rowIndex++;

        $validator = $this->validateRow($row);
        if ($validator->fails()) {
            $this->addError($currentRow, 'Validation errors', $validator->errors()->toArray());
            return;
        }

        if (!$this->validateUser($row['customer_id'], $currentRow)) return;
        if (!$this->validateVehicleCategory($row['vehicle_category_id'], $currentRow)) return;
        if (!$this->validateVehicleType($row['vehicle_type_id'], $row['vehicle_category_id'], $currentRow)) return;
        if (isset($row['vehicle_brand_id']) && !$this->validateVehicleBrand($row, $currentRow)) return;
        if (isset($row['vehicle_model_id']) && !$this->validateVehicleModel($row, $currentRow)) return;
        if (isset($row['vehicle_variant_id']) && !$this->validateVehicleVariant($row, $currentRow)) return;

        // Create the vehicle only if all validations pass
        Vehicle::create([
            'cus_id'            => $row['customer_id'],
            'category_id'       => $row['vehicle_category_id'],
            'type_id'           => $row['vehicle_type_id'],
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

    protected function validateRow(array $row)
    {
        return Validator::make($row, [
            'customer_id'           => 'required',
            'vehicle_category_id'   => 'required',
            'vehicle_no'            => 'required',
            'year'                  => 'required',
            'vehicle_type_id'       => 'required',
        ]);
    }

    protected function validateUser($customerId, $currentRow)
    {
        $user = User::find($customerId);
        if (!$user || !$user->hasRole('Customer')) {
            $this->addError($currentRow, 'customer_id', ['The selected customer_id is invalid or does not have the customer role.']);
            return false;
        }
        return true;
    }

    protected function validateVehicleCategory($categoryId, $currentRow)
    {
        if (!VehicleCategory::find($categoryId)) {
            $this->addError($currentRow, 'vehicle_category_id', ['The selected category_id is invalid.']);
            return false;
        }
        return true;
    }

    protected function validateVehicleType($typeId, $categoryId, $currentRow)
    {
        if (!VehicleType::where('id', $typeId)->where('category_id', $categoryId)->exists()) {
            $this->addError($currentRow, 'vehicle_type_id', ['The selected vehicle_type_id is invalid or does not belong to the specified category.']);
            return false;
        }
        return true;
    }

    protected function validateVehicleBrand(array $row, $currentRow)
    {
        if (!VehicleBrand::where('id', $row['vehicle_brand_id'])->where('category_id', $row['vehicle_category_id'])->exists()) {
            $this->addError($currentRow, 'vehicle_brand_id', ['The selected brand_id is invalid or does not belong to the specified category.']);
            return false;
        }
        return true;
    }

    protected function validateVehicleModel(array $row, $currentRow)
    {
        if (!VehicleModel::where('id', $row['vehicle_model_id'])
            ->where('category_id', $row['vehicle_category_id'])
            ->where('brand_id', $row['vehicle_brand_id'])
            ->exists()) {
            $this->addError($currentRow, 'vehicle_model_id', ['The selected model_id is invalid or does not belong to the specified category and brand.']);
            return false;
        }
        return true;
    }

    protected function validateVehicleVariant(array $row, $currentRow)
    {
        if (!VehicleModelVariant::where('id', $row['vehicle_variant_id'])
            ->where('category_id', $row['vehicle_category_id'])
            ->where('brand_id', $row['vehicle_brand_id'])
            ->where('model_id', $row['vehicle_model_id'])
            ->exists()) {
            $this->addError($currentRow, 'vehicle_variant_id', ['The selected variant_id is invalid or does not belong to the specified category, brand, and model.']);
            return false;
        }
        return true;
    }

    protected function addError($row, $field, $messages)
    {
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
