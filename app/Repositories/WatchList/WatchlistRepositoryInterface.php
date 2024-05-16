<?php


namespace App\Repositories\WatchList;


interface WatchlistRepositoryInterface
{
    public function getByPerson($person);

    public function addItem($data, $watchList);

    public function removeItem($data, $watchList);

    public function clearList($watchList);

}