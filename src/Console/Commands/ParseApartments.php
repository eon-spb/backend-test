<?php

namespace EON\Console\Commands;

use Illuminate\Console\Command;

class ParseApartments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ParseApartments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run parsing file test.xml';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $filePath = base_path('parseApartments/cmd/main');

        // Проверяем существование файла
        if (!file_exists($filePath)) {
        // Обработка ошибки, если файл не существует
        die("Файл не существует");
        }

        // Выполняем исполняемый файл
        exec($filePath, $output, $returnCode);
        //exec('parseApartments/cmd/main.exe');
        $this->info('Command is succesful');
        return Command::SUCCESS;
    }
}
