<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Watchlist\AddItemToWatchlistRequest;
use App\Http\Requests\Web\Watchlist\RemoveItemFromWatchlistRequest;
use App\Repositories\WatchList\WatchlistRepositoryInterface;

class WatchlistController extends Controller
{
    private $watchlistRepository;
    public function __construct(WatchlistRepositoryInterface $watchlistRepository)
    {
        $this->watchlistRepository = $watchlistRepository;
    }

    public function add(AddItemToWatchlistRequest $request)
    {
        try
        {
            $this->watchlistRepository->addItem($request->validated(), auth('person')->user()->watchList);
            return back()->with('success', 'Item added to watchlist');
        }
        catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function remove(RemoveItemFromWatchlistRequest $request)
    {
        $this->watchlistRepository->removeItem($request->validated(), auth('person')->user()->watchList);
        return back()->with('success', 'Item removed from watchlist');
    }

    public function clear()
    {
        $this->watchlistRepository->clearList(auth('person')->user()->watchList);
        return back()->with('success', 'Watchlist successfully cleared');
    }
}
