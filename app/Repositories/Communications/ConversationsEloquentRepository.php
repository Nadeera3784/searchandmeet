<?php


namespace App\Repositories\Communications;

use App\Models\Communication\Conversation;
use Vinkla\Hashids\Facades\Hashids;

class ConversationsEloquentRepository implements ConversationsRepositoryInterface
{
    public function getByUser($user)
    {
      return $user->conversations;
    }

    public function getById($id)
    {
        return Conversation::find($id);
    }

    public function create($data)
    {
        $existingConversation = null;
        $id = Hashids::connection(\App\Models\User::class)->decode($data['receiver_id'])[0] ?? null;
        $conversations = $this->getByUser(auth('agent')->user());

        foreach ($conversations as $conversation)
        {
            $user = $conversation->users->where('id', $id)->first();
            if($user)
            {
                $existingConversation = $conversation;
                break;
            }
        }

        if(!$existingConversation)
        {
            $existingConversation = auth('agent')->user()->conversations()->create();
            $existingConversation->users()->attach($id);
        };

        return $existingConversation;
    }

    public function delete($id)
    {
        $conversation = $this->getById($id);
        $conversation->messages->delete();
        $conversation->participants->delete();
        return $conversation->delete();
    }

    public function addMessage($data, $conversation){
      
        $message = $conversation->messages()->create([
            'content' => $data['content'],
            'type' => $data['type'],
            'timestamp' => $data['timestamp'],
            'user_id' => auth('agent')->user()->id
        ]);

        $ids = $conversation->users()->allRelatedIds();
        foreach ($ids as $id)
        {
            $conversation->users()->updateExistingPivot($id, ['is_read' => false]);
        }

        return $message;
    }
}