<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerInquiryCsrCommentLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_inquiry_csr_comment_log';
    protected $guarded=[];
}
