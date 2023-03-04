<?php

namespace Coderjp\Forecast;

enum WeatherCodes {
    case ClearSky;
    case FewClouds;
    case ScatteredClouds;
    case Overcast;
    case Fog;
    case Drizzle;
    case LightDrizzle;
    case HeavyDrizzle;
    case Sleet;
    case LightSleet;
    case HeavySleet;
    case Snow;
    case LightSnow;
    case HeavySnow;
    case Rain;
    case LightRain;
    case HeavyRain;
    case SnowShowers;
    case LightSnowShowers;
    case HeavySnowShowers;
    case Thunderstorm;
    case LightThunderstorm;
    case HeavyThunderstorm;
}