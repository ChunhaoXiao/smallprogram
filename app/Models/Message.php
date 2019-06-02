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
        'msg_grp',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'from');
    }

    public function from_user(){
        return $this->belongsTo('App\User', 'from');
    }

    public function to_user()
    {
        return $this->belongsTo('App\User', 'to');
    }

    public function scopeMymsg($query, $user_id)
    {
        return $query->where('from', $user_id)->orWhere('to', $user_id);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $arr = [$model->from, $model->to];
            sort($arr);
            $model->msg_grp = implode('-', $arr);
        });

    }

}
