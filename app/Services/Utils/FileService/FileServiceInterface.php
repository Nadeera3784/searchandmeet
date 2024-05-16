<?php


namespace App\Services\Utils\FileService;


interface FileServiceInterface
{
    public function upload($file, $storage_container);

    public function delete($path);

    public function move($from, $to);

    public function download($path);

    public function url($path);

    public function exists($path);

    public function get($path);

    public function size($path);
}