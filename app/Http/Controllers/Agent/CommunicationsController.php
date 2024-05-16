<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Repositories\Communications\ConversationsRepositoryInterface;
use Illuminate\Http\Request;

class CommunicationsController extends Controller
{
    private $conversationsRepository;
    public function __construct(ConversationsRepositoryInterface $conversationsRepository)
    {
        $this->conversationsRepository = $conversationsRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index(Request $request)
    {
        $conversations =  $this->conversationsRepository->getByUser(auth('agent')->user());

        return view('agent.communication.index', get_defined_vars());
    }

    public function getMessages(Request $request, $conversation)
    {
        $conversations =  $this->conversationsRepository->getMessages(auth('agent')->user());
        return view('agent.communication.index', ['conversations' => $conversations]);
    }

}
