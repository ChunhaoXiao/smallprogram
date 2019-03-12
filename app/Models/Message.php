<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
    	'from',
    	'to',
    	'content',
    	'viewed',
    	'sender_deleted',
    	'receiver_deleted',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'from');
    }
}
