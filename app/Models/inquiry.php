<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Inquiry extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function scopeInProgressForThreeHoursOrMore($query)
    {
        $threeHoursAgo = Carbon::now()->subHours(3);	
        return $query->where('status', 'In Progress')
                     ->where('updated_at', '<=', $threeHoursAgo);
    }
}
