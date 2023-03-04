<?php

namespace Coderjp\Forecast\Drivers\Weather;

use Coderjp\Forecast\ForecastedDay;
use Coderjp\Forecast\WeatherCodes;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Coderjp\Forecast\Models\Forecast;


class WeatherBit extends WeatherDriver
{

    public $codes = [
        200 => WeatherCodes::LightThunderstorm,
        201 => WeatherCodes::Thunderstorm,
        202 => WeatherCodes::HeavyThunderstorm,
        210 => WeatherCodes::LightThunderstorm,
        211 => WeatherCodes::Thunderstorm,
        212 => WeatherCodes::HeavyThunderstorm,
        221 => WeatherCodes::HeavyThunderstorm,
        230 => WeatherCodes::LightThunderstorm,
        231 => WeatherCodes::Thunderstorm,
        232 => WeatherCodes::HeavyThunderstorm,

        300 => WeatherCodes::LightDrizzle,
        301 => WeatherCodes::Drizzle,
        302 => WeatherCodes::HeavyDrizzle,
        310 => WeatherCodes::LightDrizzle,
        311 => WeatherCodes::Drizzle,
        312 => WeatherCodes::HeavyDrizzle,
        313 => WeatherCodes::Drizzle,
        314 => WeatherCodes::HeavyDrizzle,
        321 => WeatherCodes::Drizzle,

        500 => WeatherCodes::LightRain,
        501 => WeatherCodes::Rain,
        502 => WeatherCodes::HeavyRain,
        503 => WeatherCodes::HeavyRain,
        504 => WeatherCodes::HeavyRain,
        511 => WeatherCodes::Sleet,
        520 => WeatherCodes::LightRain,
        521 => WeatherCodes::LightRain,
        522 => WeatherCodes::HeavyRain,
        531 => WeatherCodes::HeavyRain,

        600 => WeatherCodes::LightSnow,
        601 => WeatherCodes::Snow,
        602 => WeatherCodes::HeavySnow,
        610 => WeatherCodes::SnowShowers,
        611 => WeatherCodes::Sleet,
        612 => WeatherCodes::LightSleet,
        613 => WeatherCodes::LightSleet,
        615 => WeatherCodes::LightSnow,
        616 => WeatherCodes::Snow,
        620 => WeatherCodes::LightSnowShowers,
        621 => WeatherCodes::SnowShowers,
        622 => WeatherCodes::HeavySnowShowers,

        701 => WeatherCodes::Fog,
        741 => WeatherCodes::Fog,

        800 => WeatherCodes::ClearSky,

        801 => WeatherCodes::FewClouds,
        802 => WeatherCodes::ScatteredClouds,
        803 => WeatherCodes::ScatteredClouds,
        804 => WeatherCodes::Overcast,
    ];


    public function sendRequest($latitude, $longitude) {

        return $this->cache("weatherbit:$latitude,$longitude", function () use ($latitude,$longitude)  {
            $key = config('forecast.weatherbit_key');

            $response = Http::get('https://api.weatherbit.io/v2.0/forecast/daily', [
                'lat' => $latitude,
                'lon' => $longitude,
                'key' => $key,
            ]);

            $data = $response->json();

            $days = collect();

            foreach($response->json()['data'] as $day) {
                $days->push($this->toModel($day));

                // Weatherbit returns 7 days. We are only after 5.
                if ($days->count() >= 5) break;
            }

            return $days;
        });
    }

    protected function toModel($data) {
        $day = new ForecastedDay();
        $day->date = date("Y-m-d", $data['ts']);
        $day->code = $this->getCode($data['weather']['code']);
        $day->temperature = $data['temp'];
        return $day;
    }

    protected function getCode($code) {
        return $this->codes[$code]->name;
    }
    
}