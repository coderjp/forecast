<?php

    namespace Coderjp\Forecast;

    use Illuminate\Contracts\Config\Repository;
    use Coderjp\Forecast\Models\Forecast as ForecastModel;
    use Coderjp\Forecast\Models\Day as DayModel;
    use ErrorException;


    class Forecast {

        protected $config;

        protected $forecastDriver;

        protected $ipDriver;

        public function __construct(Repository $config) {

            $this->config = $config;

            $this->setupWeatherDrivers();

            $this->setupIpDrivers();

        }

        public function getForecastByIp($ip) {

            $location = $this->ipDriver->getLocationByIp($ip);

            if (! $location) return false;

            $days = $this->forecastDriver->getByLocation($location->latitude, $location->longitude);

            if (! $days) return false;

            return $this->handleSave($location, $days);
        
        }

        protected function setupWeatherDrivers () {

            $previousDriver = null;

            foreach ($this->getWeatherDrivers() as $driver) {

                $forecastDriver = $this->getDriver($driver);
                
                if (! $previousDriver) {
                    $previousDriver = $forecastDriver;
                    $this->setForecastDriver($forecastDriver);
                } else {
                    $previousDriver->setFallback($forecastDriver);
                    $previousDriver = $forecastDriver;
                }
            }
        }

        protected function setupIpDrivers () {

            $previousDriver = null;

            foreach ($this->getIpDrivers() as $driver) {

                $ipDriver = $this->getDriver($driver);
                
                if (! $previousDriver) {
                    $previousDriver = $ipDriver;
                    $this->setIpDriver($ipDriver);
                } else {
                    $previousDriver->setFallback($ipDriver);
                    $previousDriver = $ipDriver;
                }
            }
        }

        protected function getWeatherDrivers() {
            return $this->config->get('forecast.drivers.weather', []);
        }

        protected function getIpDrivers() {
            return $this->config->get('forecast.drivers.ip', []);
        }

        protected function getDriver($driver) {
            return app()->make($driver);
        }

        public function setForecastDriver($driver) {
            $this->forecastDriver = $driver;
        }

        public function setIpDriver($driver) {
            $this->ipDriver = $driver;
        }

        protected function handleSave($location, $days) {
            $forecast = ForecastModel::create($location->toArray());

            $dayModels = $days->map(function ($day) {
                return new DayModel($day->toArray());
            });

            $forecast->days()->saveMany($dayModels);
            $forecast->refresh();

            return $forecast;
        }

    }