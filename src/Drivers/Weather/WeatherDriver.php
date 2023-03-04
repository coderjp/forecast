<?php

    namespace Coderjp\Forecast\Drivers\Weather;

    use Coderjp\Forecast\Drivers\Driver;

    class WeatherDriver extends Driver {

        public function getByLocation($latitude, $longitude) {

            try {

                return $this->sendRequest($latitude, $longitude);

            } catch (\Exception $e) {

                if ($this->fallback) {
                    return $this->fallback->getByLocation($latitude, $longitude);
                }

                return false;

            }

        }


    }