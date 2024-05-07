<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleCategory;
use App\Models\VehicleBrand;

class VehicleModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }
}
