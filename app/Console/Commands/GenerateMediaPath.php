<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\Image;
use App\Services\Utils\FileService\FileServiceInterface;
use Illuminate\Console\Command;

class GenerateMediaPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:mediapath';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all user sessions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(FileServiceInterface $fileService)
    {
        foreach (File::all() as $file)
        {
            if(!$file->public_path)
            {
                $file->public_path = $fileService->url($file->path);
                $file->save();
            }
        }

        foreach (Image::all() as $file)
        {
            if(!$file->public_path)
            {
                $file->public_path = $fileService->url($file->path);
                $file->save();
            }
        }
    }
}