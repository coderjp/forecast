<?php

    namespace Coderjp\Forecast\Facades;

    use Illuminate\Support\Facades\Facade;

    class Forecast extends Facade {

        protected static function getFacadeAccessor() {
            return 'forecast';
        }

    }