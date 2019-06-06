<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Message extends JsonResource
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
            'content' => $this->content,
            'sender_nickname' => $this->from_user->post->nickname??'',
            'sender_avatar' => $this->from_user->avatar_url,
            'recipient_nickname' => $this->to_user->post->nickname??'',
            'recipient_avatar' => $this->to_user->avatar_url,
            // 'from_user' => new PostResource($this->from_user->post),
            // 'to_user' => new PostResource($this->to_user->post),
            'create' => (string)$this->created_at,
            'is_me' => $this->from == $request->user()->id,
            'is_viewed' => !empty($this->viewed_at),
        ];
    }
}
