<?php

namespace App\Services;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    private Model $model;

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function execute(array $images): void
    {
        if (! isset($this->model)) {
            throw new \RuntimeException('Model must be set using setModel before calling execute.');
        }

        foreach ($images as $image) {
            $path = $this->uploadImage($image);

            $this->storeImageData($image, $path);
        }
    }

    private function uploadImage(UploadedFile $image): string
    {
        return MediaHelper::uploadFile($image, $this->getStoringPath());
    }

    private function storeImageData(UploadedFile $image, string $path): void
    {
        $this->model->images()->create([
            'imageable_id' => $this->model->id,
            'imageable_type' => $this->model->getMorphClass(),
            'path' => $path,
            'mime_type' => $image->getClientOriginalExtension(),
            'size' => $image->getSize(),
        ]);
    }

    private function getStoringPath(): string
    {
        $todayDate = today()->format('Y-m-d');
        $modelName = strtolower(class_basename($this->model));

        return "images/{$todayDate}/{$modelName}";
    }
}
