<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PromotionProducts;
use App\Models\PromotionServices;
use App\Models\PromotionImages;

class Promotions extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promotions';
    
    protected $guarded=[];

    public function promotion_products()
    {
        return $this->hasMany(PromotionProducts::class);
    }

    public function promotion_services()
    {
        return $this->hasMany(PromotionServices::class);
    }

    public function promotion_images()
    {
        return $this->hasMany(PromotionImages::class);
    }
}
