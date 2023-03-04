<?php

namespace Coderjp\Forecast\Drivers\Weather;

use Coderjp\Forecast\ForecastedDay;
use Coderjp\Forecast\WeatherCodes;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;


class OpenMeteo extends WeatherDriver
{

    public $codes = [
        0 => WeatherCodes::ClearSky,
        1 => WeatherCodes::FewClouds,
        2 => WeatherCodes::ScatteredClouds,
        3 => WeatherCodes::Overcast,
        45 => WeatherCodes::Fog,
        48 => WeatherCodes::Fog,
        51 => WeatherCodes::LightDrizzle,
        53 => WeatherCodes::Drizzle,
        55 => WeatherCodes::HeavyDrizzle,
        61 => WeatherCodes::LightRain,
        63 => WeatherCodes::Rain,
        65 => WeatherCodes::HeavyRain,
        66 => WeatherCodes::LightSleet,
        67 => WeatherCodes::HeavySleet,
        71 => WeatherCodes::LightSnow,
        73 => WeatherCodes::Snow,
        75 => WeatherCodes::HeavySnow,
        77 => WeatherCodes::Snow,
        80 => WeatherCodes::LightRain,
        81 => WeatherCodes::Rain,
        82 => WeatherCodes::HeavyRain,
        85 => WeatherCodes::LightSnowShowers,
        86 => WeatherCodes::HeavySnowShowers,
        95 => WeatherCodes::Thunderstorm,
        96 => WeatherCodes::Thunderstorm,
        99 => WeatherCodes::Thunderstorm,
    ];


    public function sendRequest($latitude, $longitude) {

        return $this->cache("openmeteo:$latitude,$longitude", function () use ($latitude,$longitude) {

            // We cannot use the URL params as the endpoint does not accept encoded parameters...
            $url = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&daily=weathercode,temperature_2m_max&timezone=Europe/London";

            $response = Http::get($url);

            $json = $response->json()['daily'];

            $days = collect();

            for ($i = 0; $i < 5; $i++) {
                $date = $json['time'][$i];
                $code = $json['weathercode'][$i];
                $temperature = $json['temperature_2m_max'][$i];

                $days->push($this->toModel($date, $code, $temperature));
            }

            return $days;
            
        });
    }

    protected function toModel($date, $code, $temperature) {
        $day = new ForecastedDay();
        $day->date = $date;
        $day->code = $this->getCode($code);
        $day->temperature = $temperature;

        return $day;
    }

    protected function getCode($code) {
        return $this->codes[$code]->name;
    }
    
}