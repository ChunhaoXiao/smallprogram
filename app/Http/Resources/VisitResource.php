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
        return [
            'nickname' => $request->type == 'viewers' ? $this->viewed->post->nickname:$this->viewers->post->nickname,
            'avatar' => $request->type == 'viewers' ? $this->viewed->avatar_url:$this->viewers->avatar_url,
            'location' => $request->type == 'viewers' ? ($this->viewed->post->location[1]??''):($this->viewers->post->location[1]??''),
            'bod' => $request->type == 'viewers' ? $this->viewed->post->bod:$this->viewers->post->bod,

        ];
    }
}
