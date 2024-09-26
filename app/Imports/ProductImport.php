<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory; // Ensure to import the ProductCategory model
use App\Models\VehicleCategory; // Ensure to import the VehicleCategory model
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    protected $errors = [];

    public function model(array $row)
    {
        $this->processRow($row);
        return null;
    }

    protected function processRow(array $row)
    {
        $validator = Validator::make($row, [
            'product_code' => 'required|unique:products,product_code',
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!ProductCategory::where('id', $value)->exists()) {
                        $fail('The selected category id ' . $value . ' is invalid for row.');
                    }
                }
            ],
            'product_name' => 'required',
            'manufacture_name' => 'required',
            'vehicle_category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!VehicleCategory::where('id', $value)->exists()) {
                        $fail('The selected vehicle category id ' . $value . ' is invalid.');
                    }
                }
            ],
            'image_paths' => 'required'
        ]);

        if ($validator->fails()) {
            $this->addError($row, 'Validation errors', $validator->errors()->toArray());
            return;
        }

        $product = Product::create([
            'product_code' => $row['product_code'],
            'category_id' => $row['category_id'],
            'product_name' => $row['product_name'],
            'manufacture_name' => $row['manufacture_name'],
            'supplier' => $row['supplier'],
            'quantity' => $row['quantity'],
            'vehicle_category_id' => $row['vehicle_category_id'],
            'description' => $row['description'],
            'cost_price' => $row['cost_price'],
            'item_number' => $row['item_number'],
        ]);

        if (!empty($row['image_paths'])) {
            $this->saveImages($row['image_paths'], $product->id);
        }
    }

    protected function saveImages($imagePaths, $productId)
    {
        $imageUrls = explode(',', $imagePaths);
        foreach ($imageUrls as $imageUrl) {
            $imageUrl = trim($imageUrl);
            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $response = \Illuminate\Support\Facades\Http::get($imageUrl);

                if ($response->failed()) {
                    $this->addError($imageUrl, 'Image Download', 'Failed to download image: ' . $imageUrl);
                    continue;
                }

                $imageName = time() . '-' . uniqid() . '.' . $extension;
                $destinationPath = public_path('uploads/product-image/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                file_put_contents($destinationPath . $imageName, $response->body());

                ProductImage::create([
                    'product_id' => $productId,
                    'images' => 'uploads/product-image/' . $imageName,
                ]);
            } else {
                $this->addError($imageUrl, 'Invalid Image', 'Invalid image extension for URL: ' . $imageUrl);
            }
        }
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
