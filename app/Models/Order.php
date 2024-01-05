<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

//    protected $with = ['package'];
    protected $fillable = [
        'order_id',
        'session_id',
        'ip_address',
        'email',
        'order_status_id',
        'total_amount',
        'user_id',
        'package_id',
    ];


    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
