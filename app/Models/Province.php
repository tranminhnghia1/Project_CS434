<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['province_id','name','type','slug'];
    
    function districts(){
        return $this->hasMany('App\Models\District');
    } 
}
