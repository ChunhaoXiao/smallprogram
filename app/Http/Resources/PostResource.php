<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
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
            'post' => $request->user ? $this->content : Str::limit($this->content, 75),
            'gender' => $this->gender,
            'contact' => $this->contact,
            'pictures' => PostPictureResource::collection($request->path() == 'api/users' ? $this->pictures->take(3) : $this->pictures),
            'created_at' => (string)$this->created_at,
            'update_at' => (string)$this->updated_at,
        ];
    }
}
