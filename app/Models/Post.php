<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    	'content',
    	'user_id',
    	'gender',
    	'is_show',
    	'contact',
        'bod',
        'marriage',
        'location',
        'hobby',
        'nickname',
        'avatar',
    ];

    protected $casts = [
        'location' => 'array',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'bod',
    ];

    public function getBirthAttribute()
    {
        //return $this->bod? ->format('Y年');
        return $this->bod ? $this->bod->format('Y年') : '' ;
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function pictures()
    {
    	return $this->hasMany('App\Models\PostPicture', 'post_id');
    }



    public function savePictures($pictures)
    {
    	if(is_array($pictures))
    	{
    		if(empty($pictures))
    		{
    			return $this->pictures()->delete();
    		}

    		$old_pictures = $this->pictures->pluck('path')->toArray()?? [];
    		$new_pictures = array_diff($pictures, $old_pictures);
    		if($new_pictures)
    		{
    			foreach($new_pictures as $picture)
	    		{
	    			$datas[] = ['path' => $picture];
	    		}
	    		$this->pictures()->createMany($datas);
    		}
    		$toBeDeleted = array_diff($old_pictures, $pictures);
    		if($toBeDeleted)
    		{
    			$this->pictures()->whereIn('path', $toBeDeleted)->delete();
    		}
    		return true;
    	}
    }

    public function getRegtimeAttribute()
    {
        return $this->created_at ? $this->created_at->toDateString(): '';
    }

    public function setHobbyAttribute($value)
    {
        if($value)
        {
            $value = str_replace([' ', ',', '，'], ',', $value);
            $values = array_filter(array_map('trim', explode(',', $value)));
            if(!empty(($values)))
            {
                $this->attributes['hobby'] = implode(',', array_slice($values, 0, 4));
            }
        }
    }

    public function setIsShowAttribute($v)
    {
        $this->attributes['is_show'] = intval($v);
    }



    // public function scopeGender($query, $request)
    // {
    // 	if($gender = $request->gender)
    // 	{
    // 		if($gender == 'male')
    // 		{
    // 			return $query->where('gender', '男');
    // 		}
    // 		elseif($gender == 'female')
    // 		{
    // 			return $query->where('gender', '女');
    // 		}
    // 		else
    // 		{
    // 			return $query;
    // 		}
    // 	}

    // 	if(!$request->user()->post)
    // 	{
    // 		return $query;
    // 	}

    // 	$gender = $request->user()->post->gender;
    // 	$gender = $gender == '男' ? '女' : '男';
    // 	return $query->where('gender', $gender);
    // }

    // public function scopeOrder($query)
    // {
    // 	return $query->latest();
    // }
}
