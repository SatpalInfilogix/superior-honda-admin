<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;

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
            'location_image' => 'required',
        ]);

        if ($validator->fails()) {
            $this->addError($row, 'Validation errors', $validator->errors()->toArray());
            return;
        }

        // check if location is already exists
        $location_exists = Location::where('name', $row['name'])->where('deleted_at', NULL)->first();

        if(!empty($location_exists))
        {

        }else{

            $locationImage = '';
            if (!empty($row['location_image'])) {
                $locationImage = $this->uploadImageFromUrl($row['location_image']);
            }

            Location::create([
                'name' => $row['name'],
                'location_image' => $locationImage,
            ]);
        }

        return null;
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
        $savePath = public_path('uploads/locations/' . $filename);

        $directory = dirname($savePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($savePath, $imageContent);

        return 'uploads/locations/' . $filename;
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
