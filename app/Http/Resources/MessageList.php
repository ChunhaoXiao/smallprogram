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
        return array_merge([
            'content' => mb_substr($this->content, 0, 30),
            'is_sender' => $request->user()->id == $this->from,
            'created_at' => $this->getDate(),
        ], 
        (new User($this->target_user))->toArray($request));
    }
}
