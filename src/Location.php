<?php

    namespace Coderjp\Forecast;

    /**
     * Represents a Location based on an IP Address
     */
    class Location {

        public $ip;

        public $latitude;
        
        public $longitude;
        
        public $city;
        
        public $country;

        public function toArray() {
            return get_object_vars($this);
        }

    }