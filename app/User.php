<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'openid', 'api_token', 'avatar', 'gender'
    ];

    protected $with = ['post'];
    protected $withCount = ['viewed'];

    // protected $with = [
    //     'post.pictures',

    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function post()
    {
        return $this->hasOne('App\Models\Post')->withDefault();
    }

    public function sentFavorites()
    {
        return $this->hasMany('App\Models\Favorite', 'from_user');
    }

    public function receivedFavorites()
    {
        return $this->hasMany('App\Models\Favorite', 'to_user');
    }

    public function sentMessages()
    {
        return $this->hasMany('App\Models\Message', 'from')->where('sender_deleted', 0);
    }

    public function receivedMessages()
    {
        return $this->hasMany('App\Models\Message', 'to')->where('receiver_deleted', 0);
    }

    //黑名单
    public function blacklists()
    {
        return $this->hasMany('App\Models\Blacklist', 'user_id');
    }

    //被拉黑
    public function blacklisted()
    {
        return $this->hasMany('App\Models\Blacklist', 'black_user_id');
    }

    
    //我的收藏
    public function collections()
    {
        return $this->belongsToMany('App\User', 'collections', 'user_id', 'collection_id');
    }

    //我被收藏
    public function collectioned()
    {
        return $this->belongsToMany('App\User', 'collections', 'collection_id', 'user_id');
    }

    public function viewers()
    {
        return $this->hasMany('App\Models\Visit', 'viewer_id');
    }

    public function viewed()
    {
        return $this->hasMany('App\Models\Visit', 'viewed_id');
    }

    public function getAvatarUrlAttribute()
    {
        return substr($this->post->avatar, 0, 4) == 'http' ? $this->post->avatar : (!$this->post->avatar ? '' : asset(\Storage::url($this->post->avatar)));
    }

    public function getUser($id)
    {
        return self::with('post.pictures')->withCount('favorites')->find($id);
    }

    public function savePost($data)
    {
        if($this->post()->exists())
        {
            $this->post->update($data);
            $this->post->savePictures($data['pictures']);
            return $this->post;
        }

        $post = $this->post()->create($data);
        $post->savePictures($data['pictures']);
        return $post;
    }

    public function updateFavorite($data)
    {
        if($favorite = $this->sentFavorites()->where($data)->first())
        {
            $favorite->delete();
            return -1;
        }
        $this->sentFavorites()->create($data);
        return 1;
    }

    public function scopeHasPost($query)
    {
        return $query->has('post')->with('post.pictures');
    }

    //性别过滤
    public function scopeGender($query, $gender)
    {
        if(!empty($gender))
        {
            return $query->whereHas('post', function($query) use($gender){
                $query->where('gender', $gender);
            });
        }

        $user_gender = \Auth::user()->post->gender?? '男';
        if($user_gender)
        {
            $gender = $user_gender == '男' ? '女': '男';
            return $query->whereHas('post', function($query) use($gender){
                $query->where('gender', $gender);
            });
        }
        //return $query;

        // if(!$request->user()->post)
        // {
        //     return $query;
        // }

        
    }

    public function scopeOrder($query)
    {
        return $query->latest();
    }

    public function scopeUnblacklisted($query, $id)
    {
        return $query->whereDoesntHave('blacklists', function($query) use ($id){
            $query->where('black_user_id', $id);
        });
    }

    public function scopeFavorite($query, $id)
    {
        return $query->withCount([
            'receivedFavorites',
            'receivedFavorites as myfavorite' => function($query) use($id){
                $query->where('from_user', $id);
            },
            'receivedFavorites as new_favorite' => function($query){
                $query->where('viewed', 0);
            }
        ]);
    }

    public function scopeCollect($query, $id)
    {
        // $query->with(['collections as intercollection' => function($query) use($id){
        //     $query->where('collection_id', $id)->where();
        // }]);
        return $query->withCount(['collectioned as mycollect' => function($query) use($id){
            $query->where('user_id', $id);
        }, 'collections as collectme' => function($query)  use($id){
            $query->where('collection_id', $id);
        }]);
    }

    public function scopeBlocked($query, $id)
    {
        return $query->withCount(['blacklisted' => function($query) use ($id){
            $query->where('user_id', $id);
        }]);
        //return $query->blacklisted()->where('user_id', $id)->exists();
    }

    public function getOneMessage($id)
    {
        return $this->receivedMessages()->findOrFail($id);
    }

    public function scopeMessage($query)
    {
        $query->withCount(['receivedMessages', 'receivedMessages as new_message' => function($query){
            $query->whereNull('viewed_at');
        }]);
    }

    public function getBlacklists()
    {
        return $this->blacklists()->with('user.post')->latest()->paginate(10);
    }

    public function toggleBlackUser($user_id)
    {
        if($this->blacklists()->where('black_user_id', $user_id)->doesntExist())
        {
            $this->blacklists()->create(['black_user_id' => $user_id]);
            return 1;
        }
        $this->blacklists()->where('black_user_id', $user_id)->delete();
        return -1;
    }

    public function removeUserFromBlacklist($user_id)
    {
        if($this->blacklists()->where('black_user_id', $user_id)->exists())
        {
            return $this->blacklists()->where('black_user_id', $user_id)->delete();
        }
    }


    public function updateCollection($user_id)
    {
        if($this->collections()->where('collection_id', $user_id)->doesntExist())
        {
            $this->collections()->attach($user_id);
            return '1';
        }
        $this->collections()->detach($user_id);
        return -1;
    }

    public function getCollects($type = 'collects')
    {
        //我的关注的人
        if($type == 'collects')
        {
            return $this->collections()->withCount(['collections as intercollect' => function($query){
                $query->where('collection_id', \Auth::id());

            }])->paginate(10);
        }
        elseif($type == 'collected')
        {
            return $this->collectioned()->paginate(10);
        }
    }


    public function getViewHistory($type)
    {
        if($type == 'viewers')
        {
            return $this->viewers()->with('viewed.post')->paginate(10);
        }
        return $this->viewed()->with('viewers.post')->paginate(10);
    }

    public function getFavorites($type)
    {
        if($type == 'likes')
        {
            return $this->sentFavorites()->with('touser.post')->paginate(10);
        }
        return $this->receivedFavorites()->with('fromuser.post')->paginate(10);
    }
}
