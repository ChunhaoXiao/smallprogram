<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
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
            'id' => $this->id,
            'viewed' => $this->viewed,
            'nickname' => $request->type == 'likes'? $this->touser->post->nickname : $this->fromuser->post->nickname,
            'member_id' => $request->type == 'likes' ? $this->to_user : $this->from_user,
            'avatar' => $request->type == 'likes' ?  $this->touser->avatar_url : $this->fromuser->avatar_url,
            'created_at' => (string)$this->created_at,
            'bod' => $request->type == 'likes'? $this->touser->post->bod : $this->fromuser->post->bod,
            'location' => $request->type == 'likes'? $this->touser->post->location[1] : $this->fromuser->post->location[1],
        ];
    }
}
