<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotions;

class PromotionProducts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promotions_products';
    
    protected $guarded=[];

    public function product_promotions()
    {
        return $this->belongsTo(Promotions::class, 'promotion_id', 'id');
    }
}
