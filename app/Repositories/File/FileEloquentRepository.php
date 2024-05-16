<?php


namespace App\Repositories\File;

use App\Models\File;
use App\Services\Utils\FileService\FileServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileEloquentRepository implements FileRepositoryInterface
{
    private $fileService;
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getData($id)
    {
        return File::findorfail($id);
    }

    public function createData($uploadedFile, $storage_container)
    {
        try {
            $path = $this->fileService->upload($uploadedFile, "files/" . $storage_container);
            $file = new File();
            $file->filename = $uploadedFile->hashName();
            $file->public_path = $this->fileService->url($path);
            $file->path = $path;
            $file->type = $uploadedFile->getClientOriginalExtension();
            $file->save();

            return $file;
        }
        catch(\Exception $e)
        {
            Log::error('Unable to create file',['error' => $e]);
            throw $e;
        }
    }

    public function deleteData($id)
    {
        try {
            $file = $this->getData($id);
            $this->fileService->delete($file->path);
        }
        catch(\Exception $e)
        {
            Log::error('Unable to delete file',['error' => $e]);
        }
    }
}