<?php

    namespace Coderjp\Forecast\Drivers\Ip;
    
    use Coderjp\Forecast\Drivers\Driver;

    class IpDriver extends Driver {

        public function getLocationByIp($ip) {

            if (! $ip) return false;


            try {
                
                return $this->sendRequest($ip);

            } catch (\Exception $e) {

                if ($this->fallback) {
                    return $this->fallback->getLocationByIp($ip);
                }

                return false;

            }

        }

    }