<?php


namespace App\Repositories\Image;

use App\Models\Image;
use App\Services\Utils\FileService\FileServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageEloquentRepository implements ImageRepositoryInterface
{
    private $fileService;
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getData($id)
    {
        return Image::findorfail($id);
    }

    public function createData($file, $storage_container)
    {
        try {
            $path = $this->fileService->upload($file,"images/" . $storage_container);

            $image = new Image();
            $image->filename = $file->hashName();
            $image->path = $path;
            $image->public_path = $this->fileService->url($path);
            $image->type = $file->getClientOriginalExtension();
            $image->save();

            return $image;
        }
        catch(\Exception $e)
        {
            Log::error('Unable to create image',['error' => $e]);
            throw $e;
        }
    }

    public function deleteData($id)
    {
        try {
            $image = $this->getData($id);
            $this->fileService->delete($image->path);
            $image->delete();

        }
        catch(\Exception $e)
        {
            Log::error('Unable to delete image',['error' => $e]);
        }
    }
}