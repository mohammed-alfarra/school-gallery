<?php

namespace App\Http\Resources\Thumbnail;

use App\Helpers\MediaHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ThumbnailResource extends JsonResource
{
    /**
     * @param  mixed  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'image_id' => $this->imageable_id,
            'path' => MediaHelper::getFileFullPath($this->path),
        ];
    }
}
