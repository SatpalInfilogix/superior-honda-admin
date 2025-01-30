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
        $threeHoursAgo = date('Y-m-d H:i:s', strtotime('-3 hours'));
        return $query->where('status', 'In Progress')
                     ->where('updated_at', '<=', $threeHoursAgo);
    }
}
