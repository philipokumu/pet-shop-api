<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'uuid'=>$data->uuid,
                    'slug'=>$data->slug,
                    'title'=>$data->title,
                    'created_at'=>($data->created_at)->toDateTimeString(),
                    'updated_at'=>($data->updated_at)->toDateTimeString(),
                ];
            }),
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'first_page_url' => url('/api/v1/categories?page=1'),
    //         'from' => 1,
    //         'last_page' => $this->lastPage(),
    //         'last_page_url' => url('/api/v1/categories?page=') . $this->lastPage(),
    //         'links' => [
    //             [
    //             'url' => $this->previousPageUrl(),
    //             'label' => '&laquo; Previous',
    //             'active' => false
    //             ],
    //             [
    //             'url' => url('/api/v1/categories?page=') . $this->currentPage(),
    //             'label' => $this->currentPage(),
    //             'active' => true
    //             ],
    //             [
    //             'url' => $this->nextPageUrl(),
    //             'label' => 'Next &raquo;',
    //             'active' => false
    //             ]
    //         ],
    //         'next_page_url' => $this->nextPageUrl(),
    //         'path' => url('/api/v1/categories'),
    //         'per_page' => $this->perPage(),
    //         'prev_page_url' => $this->previousPageUrl(),
    //         'to' => $this->lastPage(),
    //         'total' => $this->total()
    //     ];
    // }
}
