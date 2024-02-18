<?php

namespace App\Console\Commands;

use App\Jobs\GenerateThumbnailsJob;
use Illuminate\Console\Command;

class GenerateThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thumbs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for existing images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new GenerateThumbnailsJob());
    }
}
