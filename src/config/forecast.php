<?php

    return [

        'drivers' => [
            
            /**
             * Weather Drivers
             * The order defined here determines the order in which they are attempted.
             * If all drivers are unsuccessful, any calls will return false.
             */
            'weather' => [
                Coderjp\Forecast\Drivers\Weather\OpenMeteo::class,
                Coderjp\Forecast\Drivers\Weather\OpenWeather::class,
                Coderjp\Forecast\Drivers\Weather\WeatherBit::class,
            ],

            /**
             * IP Drivers
             * The order defined here determines the order in which they are attempted.
             * If all drivers are unsuccessful, any calls will return false.
             */
            'ip' => [
                Coderjp\Forecast\Drivers\Ip\IpApi::class,
                Coderjp\Forecast\Drivers\Ip\IpInfo::class,
            ],

        ],

        /**
         * To prevent repeated attempts to an external API, the library caches responses.
         * Set this to 0 to disable.
         * 
         * Default: 10 minutes
         */
        'cache_time' => 10 * 60,

        /**
         * API Keys
         */
        'openweather_key' => env('OPENWEATHER_KEY'),

        'ipinfo_key' => env('IPINFO_KEY'),

        'weatherbit_key' => env('WEATHERBIT_KEY'),

        /**
         * A route is published to `/forecast`. To unpublish this route, set this to `false`.
         */
        'routes' => true,

    ];