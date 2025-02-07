<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CustomerInquiry;
use App\Models\User;
use Carbon\Carbon;

class CsrCommentLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_inquiry_csr_comment_log';
    protected $guarded=[];

    public function customer_inquiry()
    {
        return $this->belongsTo(CustomerInquiry::class, 'customer_inquiry_id', 'id');
    }

    public function csr_details()
    {
        return $this->belongsTo(User::class, 'inquiry_attended_by_csr_id', 'id');
    }
}
