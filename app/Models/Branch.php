<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bay;

class Branch extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bays()
    {
        return $this->hasMany(Bay::class);
    }
}
