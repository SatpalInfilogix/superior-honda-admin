<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getCompletedOrders(){
    	// get orders having status completed
        return self::where('status', 'completed')->get();
    }
    public function getOrdersInQueue(){
    	// get orders having status completed
        return $this->where('status', '!=', 'completed')->get();
    }
}
