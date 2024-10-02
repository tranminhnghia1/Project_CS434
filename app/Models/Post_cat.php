<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_cat extends Model
{
    //
    protected $fillable = [
        'name', 'status','slug_postCat','user_id','parent_cat'
        
    ];
    // function posts(){
    //     return $this->hasMany('App\Post');
    // } 
    function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
