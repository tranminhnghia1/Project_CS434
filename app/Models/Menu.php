<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        'name', 'status','content_desc','link','user_id','parent_id'
        
    ];

    function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
