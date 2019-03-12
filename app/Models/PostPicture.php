<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPicture extends Model
{
    protected $fillable = [
    	'path',
    	'post_id',
    ];

    public function post()
    {
    	return $this->belongsTo('App\Models\Post', 'post_id');
    }
}
