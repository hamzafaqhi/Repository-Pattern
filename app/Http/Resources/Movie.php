<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Movie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'overview' => $this->overview,
            'release_date' => $this->release_date,
            'popularity' => $this->popularity,
            'vote_average' => $this->vote_average,
            'vote_count' => $this->vote_count,
            'image' => $this->image,
            'created_at'    => $this->created_at
        ];
    }

    // public function with($request)
    // {
    //     return [
    //         'pagination' => [
    //             'total' => $this->collection->total(),
    //             'count' => $this->collection->count(),
    //             'per_page' => $this->collection->perPage(),
    //             'current_page' => $this->collection->currentPage(),
    //             'total_pages' => $this->collection->lastPage(),
    //         ],
    //     ];
    // }
}
