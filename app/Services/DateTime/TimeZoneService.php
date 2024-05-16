<?php


namespace App\Services\DateTime;

use Carbon\Carbon;

class TimeZoneService
{
    //dateTime will be a carbon object
    public function localTime($user, $dateTime, $targetFormat = null)
    {
        if(!$dateTime instanceof Carbon)
        {
            $dateTime = Carbon::parse($dateTime);
        }

        $target = 'UTC';
        $format = 'Y-m-d H:i:s';

        if($user)
        {
            if(get_class($user) === 'App\Models\User')
            {
                $target = $user->timezone->name;
            }
            elseif(get_class($user) === 'App\Models\Person')
            {
                $target = $user->timezone->name;
            }
        }

        if($targetFormat)
        {
            $format = $targetFormat;
        }

        return $dateTime->tz($target)->format($format);
    }

    public function zoneFinder($user){
        
        $target = 'UTC';

        if(get_class($user) === 'App\Models\User'){
            $target = $user->timezone->name;
        }elseif(get_class($user) === 'App\Models\Person'){
            $target = $user->timezone->name;
        }

        return $target;
    }
}