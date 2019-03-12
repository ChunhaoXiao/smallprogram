<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'user_id' => $this->id,
            'name' => $this->name,
            'avatar' => $this->avatar,
            'create_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'open_id' => $this->openid,
            'favorite_count' => $this->received_favorites_count,
            'new_favorite' => $this->when($request->user()->id == $this->id, $this->new_favorite),
            'new_message' => $this->when($request->user()->id == $this->id, $this->new_message),
            'myfavorite' => $this->myfavorite? true : false,
            'mycollect' => $this->mycollect,
            'collectme' => $this->collectme,
            'intercollect' => $this->intercollect,

            'post' => new PostResource($this->post),
        ];
    }


    public function withResponse($request, $response)
    {
        $response->header('X-Value', 'True');
    }
}
