<?php


namespace App\Repositories\MeetingRequest;


interface MeetingRequestRepositoryInterface
{
    public function getAll();

    public function getByPurchaseRequirement($purchase_requirement);

    public function create($data, $purchase_requirement, $person);

    public function update($data, $meeting_request);
}