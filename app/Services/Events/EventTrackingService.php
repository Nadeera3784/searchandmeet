<?php
namespace App\Services\Events;

use Illuminate\Support\Facades\Session;
use Rudder;

class EventTrackingService {

    function __construct(){
        Rudder::init(config('services.rudderstack.key'), array(
            "data_plane_url" => config('services.rudderstack.url'),
            "consumer" => "lib_curl",
            "debug" => true,
            "max_queue_size" => 10000,
            "batch_size" => 100
        ));
    }

    private function getUserId($user_id){
        if($user_id == null){
            if(auth('person')->check()){
                $user_id = auth('person')->user()->id;
            }
            else if(auth('api')->check()){
                $user_id = auth('api')->user()->id;
            }
            else if (Session::has('user_id'))
            {
                $user_id = Session::get('user_id');
            }
        }
        return $user_id;
    }

    private function guidv4($data = null) {
        $data = $data ?? random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function track($event, $properties, $user_id = null){

        $user_id = $this->getUserId($user_id);

        $data = array(
            "userId" => $user_id,
            "event" => $event,
            "properties" => $properties
        );

        if(!$user_id)
        {
            $data['anonymousId'] = $this->guidv4();
        }

        Rudder::track($data);
    }

    public function identify($traits, $user_id = null){

        $user_id = $this->getUserId($user_id);

        
        $data = array(
            "userId" => $user_id,
            "traits" => $traits
        );

        if(!$user_id)
        {
            $data['anonymousId'] = $this->guidv4();
        }

        Rudder::identify($data);
    }

    public function page($category, $name, $properties, $user_id = null){

        $user_id = $this->getUserId($user_id);

        $data = array(
            "userId" => $user_id,
            "category" => $category,
            "name" => $name,
            "properties" => $properties
        );

        if(!$user_id)
        {
            $data['anonymousId'] = $this->guidv4();
        }

        Rudder::page($data);
    }
}