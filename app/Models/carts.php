<?php

namespace App\Models;
use App\Models\products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    use HasFactory;

    protected $fillable=['user_id','product_id','cart_mass','cart_price'];

    public function product() {
        return $this->belongsTo(products::class, 'product_id');
    }
    
}
