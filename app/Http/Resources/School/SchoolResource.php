<?php

namespace App\Http\Resources\School;

use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * @param  mixed  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}
