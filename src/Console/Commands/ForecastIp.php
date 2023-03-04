<?php

namespace Coderjp\Forecast\Console\Commands;

use Illuminate\Console\Command;
use Coderjp\Forecast\Facades\Forecast;

class ForecastIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:ip {ip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the Forecast for an IP address';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ip = $this->argument('ip');

        $forecast = Forecast::getForecastByIp($ip);

        if (!$forecast) {

            $this->error("Failed to get the forecast for '$ip'.");

        } else {

            $this->newLine();

            $this->info("5 Day Forecast for $forecast->city, $forecast->country ($ip)");

            $this->table(
                ['Day', 'Condition', 'Temperature'],

                $forecast->days->map(function($day) {
                    return [
                        $day->date->format('D'),
                        $day->code,
                        $day->temperature . '°C',
                    ];
                })
            );

        }
    }
}
