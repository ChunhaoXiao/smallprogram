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
        return [
            'avatar' => $this->from == $request->user()->id ? $this->to_user->avatar_url : $this->from_user->avatar_url,
            'post' =>  $this->from == $request->user()->id ? $this->to_user->post : $this->from_user->post,
            'created_at' => (string)$this->created_at,
            'content' => mb_substr($this->content, 0, 30),
        ];
    }
}
