<?php

declare(strict_types=1);

namespace EON\Console;

use EON\Console\Commands\XmlParserCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $outputFilePath = storage_path('logs/parser.log');

        /**
         * Выполняется раз в 4 часа
         * В единственном экземпляре
         * Запись логов в parser.log
         */
        $schedule->command(XmlParserCommand::class)
            ->everyFourHours()->withoutOverlapping()->appendOutputTo($outputFilePath);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
