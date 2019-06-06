<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $toUser = $request->user()->id == $this->from ? $this->to_user : $this->from_user;
        return [
            'avatar' => $toUser->avatar_url,
            'nickname' => mb_substr($toUser->post->nickname,0, 10),
            'bod' => $toUser->post->bod,
            'location' => $toUser->post->location[1]??'',
            'created_at' => $this->getDate(),
            'content' => mb_substr($this->content, 0, 30),
            'is_sender' => $request->user()->id == $this->from,
            'user_id' => $toUser->post->user_id,
        ];
    }
}
