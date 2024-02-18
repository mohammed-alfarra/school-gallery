<?php

namespace App\Http\Resources\Image;

use App\Helpers\MediaHelper;
use App\Http\Resources\Thumbnail\ThumbnailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * @param  mixed  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'imageable_id' => $this->imageable_id,
            'imageable_type' => $this->imageable_type,
            'path' => MediaHelper::getFileFullPath($this->path),
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'thumbnails' => ThumbnailResource::collection($this->whenLoaded('thumbnails')),
            'created_at' => dateTimeFormat($this->created_at),
        ];
    }
}
