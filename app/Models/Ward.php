<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    //
    protected $fillable = ['ward_id','name','type','district_id'];
    function district(){
        return $this->belongsTo('App\Models\Province','district_id');
    }
}
