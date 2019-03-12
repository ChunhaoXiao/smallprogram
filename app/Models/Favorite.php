<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
    	'to_user',
    	'from_user',
    	'viewed',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'from_user');
    }
}
