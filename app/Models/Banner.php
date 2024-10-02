<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
     
    protected $fillable = [
        'name', 'status','content_desc','link','user_id','product_thumb'
        
    ];

    function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
