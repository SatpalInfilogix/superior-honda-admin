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
            'name'           => 'required',
            'branch_name'    => 'required',
            'branch_address' => 'required'
        ]);

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->toArray()
            ];
            return null;
        }

        $branch_code = $this->generateBranchCode();

        $branch = Branch::where('name', $row['branch_name'])->first();

        if ($branch) {
            $branchId = $branch->id;
        } else {
            $newBranch = Branch::create([
                'unique_code' => $branch_code,
                'name' => $row['branch_name'],
                'address' => $row['branch_address'],
            ]);
            $branchId = $newBranch->id;
        }

        Bay::create([
            'name' => $row['name'],
            'branch_id' => $branchId
        ]);

        return null;
    }

    /**
     * Generate a unique branch code
     *
     * @return string
     */
    public function generateBranchCode()
    {
        $branch = Branch::orderByDesc('unique_code')->first();
        if (!$branch) {
            $uniqueCode = 'BR0001';
        } else {
            $numericPart = (int)substr($branch->unique_code, 2); // Adjust to skip 'BR'
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $uniqueCode = 'BR' . $nextNumericPart;
        }

        return $uniqueCode;
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
