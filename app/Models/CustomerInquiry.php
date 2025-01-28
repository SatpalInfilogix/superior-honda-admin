<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;

class CustomerInquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_inquiry';
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class, 'inquiry_product_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'inquiry_location_id', 'id');
    }

    public function csr()
    {
        return $this->belongsTo(User::class, 'inquiry_attended_by_csr_id', 'id');
    }

    public function scopeInProgressForTwoHoursOrMore($query)
    {
        $twoHoursAgo = date('Y-m-d H:i:s', strtotime('-2 hours'));
        return $query->where('inquiry_status', 'in_process')
                     ->where('inquiry_created_at', '<=', $twoHoursAgo);
    }
}
