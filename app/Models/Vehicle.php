<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleModelVariant;
use App\Models\User;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(User::class, 'cus_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class);
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
}
