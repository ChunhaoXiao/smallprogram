<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Blacklist extends JsonResource
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
            'nickname' => $this->user->post->nickname,
            'avatar' => $this->user->avatar_url,
            'bod' => $this->user->post->bod,
            'location' => $this->user->post->location[1]??'',
            'user_id' => $this->user->id,
        ];
    }
}
