<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Branch;

class Bay extends Model
{
    use HasFactory;
    protected $table = 'bays';
    protected $guarded=[];

   public function branch()
    {
        return $this->belongsTo(Branch::class)->where('disable_branch', 0);
    }
}
