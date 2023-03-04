<?php

    namespace Coderjp\Forecast;

    /**
     * DayResponse
     * Represents a forecasted day response from the API
     */
    class ForecastedDay {

        public $date;

        public $code;

        public $temperature;

        public function toArray() {
            return get_object_vars($this);
        }

    }