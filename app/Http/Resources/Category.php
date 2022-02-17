<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'success' => 1,
            'data'=> [
                'uuid'=>$this->uuid,
                'slug'=>$this->slug,
                'title'=>$this->title,
                'created_at'=>($this->created_at)->toDateTimeString(),
                'updated_at'=>($this->updated_at)->toDateTimeString(),
            ],
            'error' => null,
            'errors' => [],
            'extra' => []
        ];
    }
}
