<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    protected $fillable = [
    	'user_id',
    	'black_user_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'black_user_id');
    }

    public function scopeBlacklistedUser($query, $uid)
    {
    	return $query->where('black_user_id', $id);
    }
}
