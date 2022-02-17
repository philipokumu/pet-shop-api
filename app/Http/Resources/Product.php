<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
                'price'=>$this->price,
                'category_id'=>$this->category_id,
                'description'=>$this->description,
                'created_at'=>($this->created_at)->toDateTimeString(),
                'updated_at'=>($this->updated_at)->toDateTimeString(),
            ],
            'error' => null,
            'errors' => [],
            'extra' => []
        ];
    }
}
