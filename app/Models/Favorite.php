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

    public function fromuser()
    {
    	return $this->belongsTo('App\User', 'from_user');
    }

    public function touser()
    {
    	return $this->belongsTo('App\User', 'to_user');
    }
}
