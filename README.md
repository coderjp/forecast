# Forecast

Forecast allows you to fetch the Weather Forecast for the next 5 days based on an IP address.

## Installation

Require this package with composer using the following command:

```
composer require coderjp/forecast
```

Publish the various resources needed

```
php artisan vendor:publish --provider="Coderjp\Forecast\Providers\ForecastProvider"
```

Run the migrations - this library stores all location and forecast data in the database.

```
php artisan migrate
```

## Configuration

All configuration is stored in `config/forecast.php`. By default there are a handful of drivers used for geolocation and forecasting already enabled.

Some drivers require API keys in order to use them - these can be specified in the config file.

Should a driver fail to get a response (server down, invalid/missing api key etc.), the next driver in the list will be used, and so on.

## Usage

By default, the library publishes a simple route to `/forecast`. This allows you to enter an IP address and lookup the five day forecast in the browser.

### Models

All data is cached in the database. Two models are available for querying this data:

- **`Coderjp\Forecast\Models\Forecast`** - Holds the location data
- **`Coderjp\Forecast\Models\Day`** - Holds each day's forecast

### CLI

A command line tool is available for looking up the forecast for an IP:

```
php artisan forecast:ip {ip}

5 Day Forecast for Brisbane, AU (123.211.61.50)
+-----+-----------------+-------------+
| Day | Condition       | Temperature |
+-----+-----------------+-------------+
| Sat | ScatteredClouds | 30°C        |
| Sun | Fog             | 30°C        |
| Mon | ScatteredClouds | 33°C        |
| Tue | Overcast        | 34°C        |
| Wed | Overcast        | 32°C        |
+-----+-----------------+-------------+
```
