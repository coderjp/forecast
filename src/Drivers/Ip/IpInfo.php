<?php

namespace Coderjp\Forecast\Drivers\Ip;

use Coderjp\Forecast\Location;
use Coderjp\Forecast\Drivers\Ip\IpDriver;
use Illuminate\Support\Facades\Http;


class IpInfo extends IpDriver
{

    public function sendRequest($ip) {

        return $this->cache("ipinfo:$ip", function () use ($ip) {

            $key = config('forecast.ipinfo_key');

            $response = Http::get("http://ipinfo.io/${ip}", [
                'token' => $key,
            ])->json();

            $coords = explode(',', $response['loc']);

            $location = new Location();
            $location->ip = $ip;
            $location->latitude = $coords[0];
            $location->longitude = $coords[1];
            $location->city = $response['city'];
            $location->country = $response['country'];

            return $location;
            
        });

    }
    
}