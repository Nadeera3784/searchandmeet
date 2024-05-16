<?php


namespace App\Repositories\File;

interface FileRepositoryInterface
{
    public function getData($id);

    public function createData($file,$storage_container);

    public function deleteData($id);
}