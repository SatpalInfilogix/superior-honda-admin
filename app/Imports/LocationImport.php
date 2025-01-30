<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationImport implements ToModel, WithHeadingRow
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
            'name'       => 'required',
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->toArray()
            ];
            return null;
        }

        // check if location is already exists
        $location_exists = Location::where('name', $row['name'])->where('deleted_at', NULL)->first();

        if(!empty($location_exists))
        {

        }else{
            Location::create([
                'name' => $row['name'],
            ]);
        }

        return null;
    }

    /**
     * Generate a unique branch code
     *
     * @return string
     */

    /**
     * Get validation errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
