<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
                'first_name'=>$this->first_name,
                'last_name'=>$this->last_name,
                'email'=>$this->email,
                'address'=>$this->address,
                'avatar'=>$this->avatar,
                'phone_number'=>$this->phone_number,
                'is_marketing'=>$this->is_marketing,
                'created_at'=>($this->created_at)->toDateTimeString(),
                'updated_at'=>($this->updated_at)->toDateTimeString(),
            ]
        ];
    }
}
