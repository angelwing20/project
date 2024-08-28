<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkouts extends Model
{
    use HasFactory;

    protected $fillable=['order_code','user_id','product_id','mass','price','delivery_type','address','price','status'];
}
