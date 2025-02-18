<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotions;
use App\Models\Product;

class PromotionServices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promotions_services';
    
    protected $guarded=[];

    public function services_promotions()
    {
        return $this->belongsTo(Promotions::class, 'promotion_id', 'id');
    }

    public function service_details()
    {
        return $this->belongsTo(Product::class, 'service_id', 'id');
    }
}
