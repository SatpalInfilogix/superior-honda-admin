<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Branch;
use App\Models\Location;

class BranchLocations extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->whereNull('deleted_at');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->whereNull('deleted_at');
    }
}
