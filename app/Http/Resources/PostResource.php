<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'post' => $request->user ? $this->content : Str::limit($this->content, 75),
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'contact' => $this->contact,
            'pictures' => PostPictureResource::collection($request->path() == 'api/users' ? $this->pictures->take(3) : $this->pictures),
            'created_at' => !empty($this->created_at)? $this->created_at->toDateString():'',
            'updated_at' => !empty($this->updated_at)? $this->updated_at->toDateString():'',
            'gender_index' => array_search($this->gender, ['男', '女']),
            'marriage_index' => array_search($this->marriage, ['未婚', '离异', '丧偶']),
            'marriage' => $this->marriage,
            'user_id' => $this->user_id,
            'avatarUrl' => substr($this->avatar, 0, 4) == 'http' ? $this->avatar : (!$this->avatar ? '' : asset(\Storage::url($this->avatar))),
            'avatar' => $this->avatar,
            'bod' => $request->path() == 'api/posts' ? $this->bod->toDateString() :$this->birth,
            'region' => $request->path() == 'api/posts' ? $this->location : ($this->location[1]?? ''),
            
            'hobby' => $this->hobby,
            'hobby_arr' => array_map('trim', explode(',', $this->hobby)),
            'content' => $this->content,
            'is_show' => $this->is_show,
        ];
    }
}
