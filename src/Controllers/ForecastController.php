<?php
namespace Coderjp\Forecast\Controllers;

use Coderjp\Forecast\Forecast;
use Illuminate\Http\Request;

class ForecastController
{
    public function index(Forecast $forecast, Request $request) {

        $ip = $request->ip();

        $weatherForecast = $forecast->getForecastByIp($ip);

        return view('forecast::overview', [
            'forecast' => $weatherForecast,
            'ip' => $ip
        ]);
    }


    public function lookup(Forecast $forecast, Request $request) {

        $ip = $request->input('ip');

        $weatherForecast = $forecast->getForecastByIp($ip);

        return view('forecast::overview', [
            'forecast' => $weatherForecast,
            'ip' => $ip
        ]);

    }
}