<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Communication\SaveMessageRequest;
use App\Http\Resources\ConversationResource;
use App\Repositories\Communications\ConversationsRepositoryInterface;
use Illuminate\Http\Request;

class CommunicationsController extends ApiController
{
    private $conversationsRepository;
    public function __construct(ConversationsRepositoryInterface $conversationsRepository)
    {
        $this->conversationsRepository = $conversationsRepository;
    }

    public function getConversations(Request $request)
    {
        $conversations =  $this->conversationsRepository->getByUser(auth('agent')->user());
        return $this->sendResponse('success', ConversationResource::collection($conversations), 200);
    }

    public function getConversation(Request $request, $conversation)
    {
        $conversation->users()->updateExistingPivot(auth('agent')->user()->id, ['is_read' => true]);
        return $this->sendResponse('success', new ConversationResource($conversation), 200);
    }

    public function createConversation(Request $request)
    {
        $conversation = $this->conversationsRepository->create($request->all());
        return $this->sendResponse('success', new ConversationResource($conversation), 200);
    }

    public function saveMessage(SaveMessageRequest $request, $conversation)
    {
        $this->conversationsRepository->addMessage($request->validated(), $conversation);
        return $this->sendResponse('success', new ConversationResource($conversation), 200);
    }


}
