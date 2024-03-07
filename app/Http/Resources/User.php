<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->createToken(config('app.name'))->plainTextToken,
        ];
    }

    public function with($request)
    {
        return [
            'pagination' => [
                'total' => $this->collection->total(),
                'count' => $this->collection->count(),
                'per_page' => $this->collection->perPage(),
                'current_page' => $this->collection->currentPage(),
                'total_pages' => $this->collection->lastPage(),
            ],
        ];
    }
}
