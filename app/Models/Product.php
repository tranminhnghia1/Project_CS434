<?php

namespace App\Models;
use App\Models\Review;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    //
    use SoftDeletes;
   
    protected $fillable = [
        'name', 'status','content','slug_product','price_product','number_product','featured','product_thumb','product_image'
        ,'parent_cat','content_desc','user_id','cat_id','discount'
        
    ];
    function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    function product_cat(){
        return $this->belongsTo('App\Models\Product_cat','cat_id');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
}
