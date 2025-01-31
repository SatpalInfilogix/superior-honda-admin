<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductCategory;

class ProductParentCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products_parent_categories';
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(ProductCategory::class, 'id', 'category_id');
    }
}
