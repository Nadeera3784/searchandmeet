<?php

namespace App\Services\Agora;

class RtmTokenBuilder
{
    const RoleRtmUser = 1;
    public static function buildToken($appID, $appCertificate, $userAccount, $privilegeExpireTs){
        $token = AccessToken::init($appID, $appCertificate, $userAccount, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpireTs);
        return $token->build();
    }
}