<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Make sure to import Log
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
            'product_code' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Product::where('product_code', $value)->whereNull('deleted_at')->exists()) {
                        $fail('The product code ' . $value . ' has already been taken.');
                    }
                }
            ],
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
            'vehicle_type_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!VehicleType::where('id', $value)->exists()) {
                        $fail('The selected vehicle type id ' . $value . ' is invalid.');
                    }
                }
            ],
            'is_oem' => 'required|boolean',
            'is_service' => 'required|boolean',
            'is_used_part' => 'required|boolean',
            'accesseries' => 'required|boolean',
            'service_icon' => 'required_if:is_service,1',
            'short_description' => 'required_if:is_service,1',
        ]);

        if ($validator->fails()) {
            $this->addError($row, 'Validation errors', $validator->errors()->toArray());
            return;
        }

        if (!empty($row['vehicle_brand_id'])) {
            $vehicleBrand = VehicleBrand::where('id', $row['vehicle_brand_id'])
                ->where('category_id', $row['vehicle_category_id'])->first();
            if (!$vehicleBrand) {
                $this->addError($row, 'vehicle_brand_id', ['The selected brand_id is invalid or does not belong to the specified category.']);
                return;
            }
        }

        if (!empty($row['vehicle_model_id'])) {
            $vehicleModel = VehicleModel::where('id', $row['vehicle_model_id'])
                ->where('category_id', $row['vehicle_category_id'])
                ->when(!empty($row['vehicle_brand_id']), function ($query) use ($row) {
                    return $query->where('brand_id', $row['vehicle_brand_id']);
                })->first();

            if (!$vehicleModel) {
                $this->addError($row, 'vehicle_model_id', ['The selected model_id is invalid or does not belong to the specified category and brand.']);
                return;
            }
        }

        if (!empty($row['vehicle_variant_id'])) {
            $vehicleVariant = VehicleModelVariant::where('id', $row['vehicle_variant_id'])
                ->where('category_id', $row['vehicle_category_id'])
                ->when(!empty($row['vehicle_brand_id']), function ($query) use ($row) {
                    return $query->where('brand_id', $row['vehicle_brand_id']);
                })
                ->when(!empty($row['vehicle_model_id']), function ($query) use ($row) {
                    return $query->where('model_id', $row['vehicle_model_id']);
                })->first();

            if (!$vehicleVariant) {
                $this->addError($row, 'vehicle_variant_id', ['The selected variant_id is invalid or does not belong to the specified category, brand, and model.']);
                return;
            }
        }

        // Validate is_service and accesseries
        if ($row['is_service'] == 0 && $row['accesseries'] != 1) {
            $this->addError($row, 'accesseries', 'If is_service is 0, accesseries must be 1.');
        } elseif ($row['accesseries'] == 1 && $row['is_service'] != 0) {
            $this->addError($row, 'is_service', 'If accesseries is 1, is_service must be 0.');
        } elseif ($row['is_service'] == 1 && $row['accesseries'] == 1) {
            if (empty($row['service_icon'])) {
                $row['is_service'] = 0;
            }
        }

        $serviceIcon = '';
        if (!empty($row['service_icon'])) {
            $serviceIcon = $this->uploadImageFromUrl($row['service_icon']);
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
            'brand_id' => $row['vehicle_brand_id'],
            'model_id' => $row['vehicle_model_id'],
            'varient_model_id' => $row['vehicle_variant_id'],
            'type_id' => $row['vehicle_type_id'],
            'is_oem' => $row['is_oem'],
            'is_service' => $row['is_service'],
            'used_part' => $row['is_used_part'],
            'popular' => $row['popular'],
            'access_series' => $row['accesseries'],
            'short_description' => $row['short_description'],
            'service_icon' => $serviceIcon,
            'year'         => $row['year'] ?? NULL
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
                $response = Http::get($imageUrl);

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

    public function uploadImageFromUrl(string $imageUrl): string
    {
        $response = Http::get($imageUrl);

        if ($response->failed()) {
            Log::error('Failed to fetch image from URL: ' . $imageUrl);
            return '';
        }

        $imageContent = $response->body();
        $mimeType = $response->header('Content-Type');

        // Use the mime type to determine the extension
        $extension = $this->getExtensionFromMimeType($mimeType);
        if (!$extension) {
            Log::error('Unable to determine file extension for mime type: ' . $mimeType);
            return '';
        }

        $filename = uniqid('', true) . '.' . $extension;
        $savePath = public_path('uploads/service-icons/' . $filename);

        $directory = dirname($savePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($savePath, $imageContent);

        return 'uploads/service-icons/' . $filename;
    }

    protected function getExtensionFromMimeType(string $mimeType): ?string
    {
        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            // Add more mime types and their corresponding extensions as needed
        ];

        return $extensions[$mimeType] ?? null;
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
