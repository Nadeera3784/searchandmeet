<?php


namespace App\Repositories\Matchmaking;

use App\Models\Matchmaking\Match;

class MatchEloquentRepository implements MatchRepositoryInterface
{
    public function getById($id)
    {
        return Match::find($id);
    }

    public function create($data)
    {
        return Match::create($data);
    }

    public function addItem($match, $item)
    {
        return $match->items()->create([
            'item_type' => $item['type'],
            'item_id' => $item['id']
        ]);
    }

    public function update($data, $id)
    {
        $match = $this->getById($id);
        $match->update($data);
        $match->refresh();
        return $match;
    }

    public function delete($id)
    {
        $match = $this->getById($id);
        $match->items()->delete();
        $match->delete();
    }
}