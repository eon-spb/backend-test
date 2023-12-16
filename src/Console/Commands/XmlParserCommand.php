<?php

namespace EON\Console\Commands;

use EON\Http\Services\XmlParserService;
use Illuminate\Console\Command;

class XmlParserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:parse {path?} {--without_storage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parser XML files';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(XmlParserService $xmlParserService)
    {
        $startTime = now();

        // Определение пути до файла
        if (!$path = $this->argument('path')) {
            $path = $xmlParserService->path ?? '/tmp/test.xml';
        }

        // Если опция --without_storage не указана, то добавляем префикс storage_path
        if (!$this->option('without_storage')){
            $path = storage_path($path);
        }

        // Проверка существования файла
        if (!file_exists($path)) {
            $this->error("File not founded: $path");
            return 1;
        }

        // Получение данных из XML файла
        $data = $xmlParserService->getData($path);

        // Итерация данных по частям и сохранение
        foreach ($xmlParserService->generator($data) as $chunk) {
            try {
                $xmlParserService->saveData($chunk);
            }catch (\Throwable $e) {
                $this->error("Error: {$e->getMessage()}, code: {$e->getCode()} ");
                return 1;
            }
        }

        $finishedTime = now();
        $execution = $finishedTime->diffInSeconds($startTime);

        // Запись осуществляется при выполнении cron в parser.log
        $this->info(
            "Date Started: {$startTime->format('Y-m-d h:i:s')}" . "\n" .
            "Date Finished: {$finishedTime->format('Y-m-d h:i:s')}" . "\n" .
            "Execution time: $execution seconds" . "\n" .
            "Max memory usage: {$xmlParserService->memoryPeakUsage()}" . "\n"
        );

        return 0;
    }
}
