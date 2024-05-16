<?php


namespace App\Repositories\Image;

interface ImageRepositoryInterface
{
    public function getData($id);

    public function createData($file,$storage_container);

    public function deleteData($id);
}