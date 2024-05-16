<?php

namespace App\Services\Account;
use Illuminate\Support\Facades\Session;
use App\Repositories\Meeting\MeetingRepositoryInterface;

class HealthManagerService{

    private $user_id = null;
    private $meetingRepository;

    function __construct(MeetingRepositoryInterface $meetingRepository){
       $this->setUser();
       $this->meetingRepository = $meetingRepository;
    }

    public function  setUser(){
        if(auth('person')->check()){
            $this->user_id = auth('person')->user()->id;
        }
    }

    public function checkMissingMeetings(){
       if($this->user_id){
          $meetings = $this->meetingRepository->getAll(auth('person')->user());
       }
    }

}