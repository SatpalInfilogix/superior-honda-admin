<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Bay; // Make sure Bay model is imported
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BayImport implements ToModel, WithHeadingRow
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
            'name'      => 'required',
            'branch_id' => 'required|exists:branches,id',
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->toArray()
            ];
            return null;
        }


        $branch = Branch::where('id', $row['branch_id'])->first();

        if ($branch) {
            $branchId = $branch->id;
            Bay::create([
                'name' => $row['name'],
                'branch_id' => $branchId
            ]);
        }

        return null;
    }

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
