<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Branch;
use App\Models\CustomerInquiry;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'locations';
    protected $guarded=[];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function customerInquiries()
    {
        return $this->hasMany(customerInquiry::class);
    }
}
