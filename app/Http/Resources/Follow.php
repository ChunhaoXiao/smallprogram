<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Follow extends JsonResource
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
            'nickname' => $this->post->nickname,
            'avatar' => $this->post->user->avatar_url,
            'user_id' => $this->post->user_id,
            'bod' => $this->post->bod,
            'location' => $this->post->location[1]?? '',
        ];
    }
}
