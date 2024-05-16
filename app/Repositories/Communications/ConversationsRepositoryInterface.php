<?php

namespace App\Repositories\Communications;

interface ConversationsRepositoryInterface
{
    public function getByUser($user);

    public function getById($id);

    public function create($data);

    public function delete($id);

    public function addMessage($data, $conversation);

}