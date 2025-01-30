<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class ParentCategoriesForProducts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parent_categories_for_products';
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}

