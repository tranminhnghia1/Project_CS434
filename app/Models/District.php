<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    protected $fillable = ['district_id','name','type','province_id'];
    function province(){
        return $this->belongsTo('App\Models\Province','province_id');
    }
    function wards(){
        return $this->hasMany('App\Models\Ward');
    } 
}
