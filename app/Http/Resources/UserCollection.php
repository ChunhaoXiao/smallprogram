<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'data' => $this->collection,
            'mygender' => $request->user()->post ? ($request->user()->post->gender == '男'? 2 : 1) : 2,
        ];
    }
}
