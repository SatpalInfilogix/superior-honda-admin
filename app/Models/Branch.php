<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bay;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function bays()
    {
        return $this->hasMany(Bay::class);
    }
}
