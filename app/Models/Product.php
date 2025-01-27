<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded=[];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function variant()
    {
        return $this->belongsTo(VehicleModelVariant::class, 'varient_model_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
