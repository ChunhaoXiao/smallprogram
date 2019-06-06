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
        $user = $request->user();
        $toUser = $this->from_user == $user->id ? $this->touser : $this->fromuser;
        return [
            'id' => $this->id,
            'viewed' => $this->viewed,
            'nickname' => $toUser->post->nickname,
            'user_id' => $toUser->post->user_id,
            'avatar' => $toUser->avatar_url,
            'created_at' => (string)$this->created_at,
            'bod' => $toUser->post->bod,
            'location' => $toUser->post->location[1]?? '',
        ];
    }
}
