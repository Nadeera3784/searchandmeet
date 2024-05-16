<?php

namespace App\Listeners;

use App\Enums\Person\AccountStatus;
use App\Enums\PurchaseRequirementStatus;
use App\Events\PersonStatusCheck;
use App\Models\Business;
use App\Models\PurchaseRequirement;
use App\Notifications\Person\PersonAccountVerified;
use App\Repositories\Person\PersonRepositoryInterface;

class PersonStatusCheckListener
{
    private $personRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PersonStatusCheck $event)
    {
        $person = $event->person;
        if($person->status === AccountStatus::OnBoarding)
        {
            if($person->agent_id && Business::where('person_id', $person->id)->exists())
            {
               $this->verify($person);
            }
            else if(Business::where('person_id', $person->id)->exists())
            {
                $this->personRepository->update([
                    'status' =>  AccountStatus::Unverified
                ], $person->id);
            }
        }
        else if($person->status === AccountStatus::Unverified)
        {
            if(!Business::where('person_id', $person->id)->exists())
            {
                $this->personRepository->update([
                    'status' =>  AccountStatus::OnBoarding
                ], $person->id);
            }
            else
            {
                $this->verify($person);
            }
        }
    }

    private function verify($person)
    {
        $this->personRepository->update([
            'status' =>  AccountStatus::Verified
        ], $person->id);

        PurchaseRequirement::where('person_id', $person->id)->update(['status' => PurchaseRequirementStatus::Published]);
        $person->notify(new PersonAccountVerified());
    }
}
