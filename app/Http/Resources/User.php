<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'user_id' => $this->id,
            'nickname' => $this->post->nickname??'',
            'location' => $this->post->location[1]??'',
            'avatar' => $this->avatar_url,
            'register_time' => $this->post->regtime,//post->created_at->toDateString(),
            'bod' => $this->post->birth,
            'gender' => $this->post->gender,
            'marriage' => $this->post->marriage,
            'contact' => $this->post->contact,
            'is_show' => $this->post->is_show,
            'hobby' => $this->post->hobby,
            'hobby_arr' => explode(',', $this->post->hobby),
            'short_content' => mb_substr($this->post->content, 0 ,45),
            'pictures' => PostPictureResource::collection($this->post->pictures),
            'favorite_count' => intval($this->received_favorites_count),
            'views' => $this->viewed_count,

            $this->mergeWhen($request->user, [
                'myfavorite' => $this->myfavorite? true : false,
                'mycollect' => $this->mycollect,
                'collectme' => $this->collectme,
                'intercollect' => $this->intercollect,
                'blocked' => $this->blacklisted_count,
                'is_myself' => $request->user()->id == $this->id,
                'full_content' => $this->post->content, 
            ]),
            $this->mergeWhen($request->path()== 'api/profile', [
                'new_favorite' =>  $this->new_favorite,
                'new_message' =>  $this->new_message,
                'total_messages' => $this->totals,
            ]),

            $this->mergeWhen($request->path() == 'api/posts', [
                'my_location' => $this->post->location,
                'my_bod' => !empty($this->post->bod)? $this->post->bod->toDateString():'',
                'my_content' => $this->post->content,
            ]),

            'open_id' => $this->openid,
        ];
    }


    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
