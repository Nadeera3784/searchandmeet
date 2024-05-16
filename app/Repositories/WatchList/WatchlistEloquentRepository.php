<?php


namespace App\Repositories\WatchList;


class WatchlistEloquentRepository implements WatchlistRepositoryInterface
{

    public function getByPerson($person)
    {
        return $person->watchlist;
    }

    public function addItem($data, $watchList)
    {
        $pr = $watchList->items()->where('purchase_requirement_id', $data['purchase_requirement_id'])->first();
        if(!$pr)
        {
            return $watchList->items()->create([
                'purchase_requirement_id' => $data['purchase_requirement_id']
            ]);
        }
        else
        {
            throw new \Exception("Item already in watch list");
        }
    }

    public function removeItem($data, $watchList)
    {
        return $watchList->items()->where('purchase_requirement_id', $data['purchase_requirement_id'])->delete();
    }

    public function clearList($watchList)
    {
        return $watchList->items()->delete();
    }
}