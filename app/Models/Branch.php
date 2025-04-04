<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bay;
use App\Models\BranchLocations;

use App\Models\Location;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function bays()
    {
        return $this->hasMany(Bay::class);
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id')->whereNull('deleted_at');
    }

    public function branch_locations()
    {
        return $this->hasMany(BranchLocations::class);
    }
}
