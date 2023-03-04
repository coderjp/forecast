<?php

namespace Coderjp\Forecast\Drivers\Ip;

use Coderjp\Forecast\Location;
use Coderjp\Forecast\Drivers\Ip\IpDriver;
use Illuminate\Support\Facades\Http;

class IpApi extends IpDriver
{

    public function sendRequest($ip) {

        return $this->cache("ipapi:$ip", function () use ($ip) {

            $response = Http::get("http://ip-api.com/json/${ip}")->json();

            $location = new Location();
            $location->ip = $ip;
            $location->latitude = $response['lat'];
            $location->longitude = $response['lon'];
            $location->city = $response['city'];
            $location->country = $response['country'];  
    
            return $location;
            
        });

    }
    
}