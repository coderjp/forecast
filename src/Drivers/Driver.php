<?php

    namespace Coderjp\Forecast\Drivers;
    use Illuminate\Support\Facades\Cache;

    class Driver {

        protected $fallback;

        public function setFallback($fallback) {

            $this->fallback = $fallback;

        }

        protected function getCacheTime() {
            return config('forecast.cache_time');
        }
        
        protected function cache($key, $callback) {
            return Cache::remember($key, $this->getCacheTime(), $callback);
        }

    }