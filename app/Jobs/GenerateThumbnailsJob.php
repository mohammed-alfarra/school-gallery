<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class GenerateThumbnailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (Image::all() as $image) {
            $originalPath = Storage::disk(null)->path($image->path);

            $smallThumbnailPath = $this->getThumbnailPath($image->path, 'small');
            $this->generateThumbnail($originalPath, $smallThumbnailPath, 100);

            $mediumThumbnailPath = $this->getThumbnailPath($image->path, 'medium');
            $this->generateThumbnail($originalPath, $mediumThumbnailPath, 200);

            $largeThumbnailPath = $this->getThumbnailPath($image->path, 'large');
            $this->generateThumbnail($originalPath, $largeThumbnailPath, 300);
        }
    }

    private function generateThumbnail($originalPath, $thumbnailPath, $size): void
    {
        $image = ImageManager::gd()->read($originalPath);

        $image->scale(width: $size);

        $image->save($thumbnailPath);
    }

    private function getThumbnailPath($originalPath, $size): string
    {
        $thumbnailsDirectory = str_replace('images', 'thumbnails', dirname($originalPath));

        $filename = pathinfo($originalPath, PATHINFO_FILENAME);

        $thumbnailFilename = "{$filename}-{$size}.jpg";

        return "{$thumbnailsDirectory}/{$thumbnailFilename}";
    }
}
