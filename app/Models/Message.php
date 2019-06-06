<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Message extends Model
{
    protected $fillable = [
    	'from',
    	'to',
    	'content',
    	'viewed_at',
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

    public function scopeGroup($query, $user_id)
    {
        return $query->where('from', $user_id)->orWhere('to', $user_id)->select([DB::raw('MAX(id) AS mid'), 'msg_grp'])->groupBy('msg_grp')->orderBy('mid', 'desc');
    }

    public function scopeSlice($query, $page)
    {
        return $query->offset(($page-1) * 10)->limit(10);
    }

    public function scopeRange($query, $ids)
    {
        return $query->whereIn('id', $ids)->with(['from_user', 'to_user'])->orderBy('id', 'desc');
    }

    public function scopeDialog($query, $ids)
    {
        return $query->whereIn('from', $ids)->whereIn('to', $ids)->with(['from_user.post', 'to_user.post'])->orderBy('id', 'desc')->limit(10);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            if($model->from == $model->to)
            {
                return false;
            }

            $arr = [$model->from, $model->to];
            sort($arr);
            $model->msg_grp = implode('-', $arr);
        });

    }

    public function getDate()
    {
        if($this->created_at->isToday())
        {
            return $this->created_at->format('H:i');
        }
        return $this->created_at->format('n月j日');
    }

    // public static function markAsRead($datas)
    // {
    //      $ids = $datas->filter(function($item){
    //             return $item->to == Auth::id();
    //         })->pluck('id');
    //     self::whereIn('id', $ids)->whereNull('viewed_at')->update(['viewed_at' => now()]);
    // }

}
