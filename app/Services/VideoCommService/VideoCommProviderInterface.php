<?php


namespace App\Services\VideoCommService;


interface VideoCommProviderInterface
{
    public function setUser($user = null);
    public function login();
    public function logout();

    public function getDirectLoginUrl($redirect = null);
    public function getChannelLink($type, $id);
    public function getChannelParticipantJoinLink($type, $id);
    public function getAnonymousJoinLink($type, $id);
    public function createMeeting($data);

}