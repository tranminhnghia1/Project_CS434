<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
     
    protected $fillable = [
        'name', 'status','content_desc','link','user_id','slider_thumb'
        
    ];

    function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
