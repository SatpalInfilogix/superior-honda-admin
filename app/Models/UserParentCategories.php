<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class UserParentCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_parent_categories';
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
