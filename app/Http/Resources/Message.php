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
        return array_merge([
            'content' => $this->content,
            'create' => (string)$this->created_at,
            'is_me' => $this->from == $request->user()->id,
            'is_viewed' => !$this->unread(),
        ], (new User($this->from_user))->toArray($request));
    }
}
