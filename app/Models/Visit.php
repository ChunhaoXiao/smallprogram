<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
    	'viewer_id', 'viewed_id', 'numbers'
    ];

    public function viewers()
    {
    	return $this->belongsTo('App\User', 'viewer_id');
    }

    public function viewed()
    {
    	return $this->belongsTo('App\User', 'viewed_id');
    }
}
