<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'data' => [
                'uuid' => $this->uuid,
                'amount' => $this->amount,
                'delivery_fee' => $this->delivery_fee,
                'products' => $this->products,
                'created_at' => ($this->created_at)->toDateTimeString(),
                'updated_at' => ($this->updated_at)->toDateTimeString()
        ],
        'error' => null,
        'errors' => [],
        'extra' => []
        ];
    }
}
