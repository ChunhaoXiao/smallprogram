<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $toUser = $request->user()->id == $this->viewer_id ? $this->viewed : $this->viewers;

        return [
            'nickname' => $toUser->post->nickname,
            'user_id' => $toUser->post->user_id,
            'avatar' => $toUser->avatar_url,
            'location' => $toUser->post->location[1]?? '',
            'bod' => $toUser->post->bod,
        ];
    }
}
