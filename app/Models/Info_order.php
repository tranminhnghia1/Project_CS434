<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info_order extends Model
{
    //
    protected $fillable = [
        'order_code', 'image_product','product_name','fullname',
        'address','province','district','ward','email','note','status','payment'
        ,'total_price','sub_total','product_price','phone_number','num_order','info_cart'
        
    ];
}
