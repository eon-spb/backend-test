<?php

namespace Tests\Feature\Commands;

use Database\Factories\ApartmentFactory;
use EON\Http\Services\XmlParserService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Tests\TestCase;

class XmlParserTest extends TestCase
{
    use LazilyRefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->xmlParserService = new XmlParserService();
        if (!File::exists(storage_path($this->xmlParserService->path))) {
            $this->artisan('test-xml:create');
        }
    }

    // Тестирует, что команда использует меньше 124мб памяти и выполняется быстрее 30 минут
    public function test_console_parser_command_memory_limit_and_execution_time(): void
    {
        $startTime = microtime(true);
        $memoryUsageBefore = $this->xmlParserService->memoryPeakUsage();

        $this->artisan('xml:parse')->assertSuccessful();

        $finishTime = microtime(true);
        $memoryUsageAfter = $this->xmlParserService->memoryPeakUsage();

        $execution = round($finishTime - $startTime, 2);
        $maxMemoryForCommand = $memoryUsageAfter - $memoryUsageBefore;

        $this->assertDatabaseCount('apartments', 500000);
        $this->assertLessThan(60 * 30, $execution);
        $this->assertLessThan(124, $maxMemoryForCommand);
    }

    // Проверка корректной работы параметров и опций команды
    public function test_console_parser_command_params_and_options(): void
    {
        $this->partialMock(XmlParserService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getData')->andReturn([1,2,3,4,5]);
            $mock->shouldReceive('generator')->andReturn([]);
            $mock->shouldReceive('validation')->andReturn([]);
            $mock->shouldReceive('saveData')->passthru();
        });

        $this->artisan('xml:parse', ['path' => $this->xmlParserService->path])->assertSuccessful();

        $path = '***';
        $this->artisan('xml:parse', ['path' => $path])->assertFailed();

        $path = base_path() . '/storage' . $this->xmlParserService->path;
        $this->artisan('xml:parse', ['path' => $path, '--without_storage' => true])->assertSuccessful();
    }

    // Тестирует сохранение в базу данных
    public function test_parser_xml_save_data()
    {
        $id = 0;
        $data = ApartmentFactory::new()->count(5)->make([
            'id' => function () use(&$id) {
                return ++$id;
            }
        ])->toArray();

        $result = $this->xmlParserService->saveData($data);

        $this->assertTrue($result);
        $this->assertDatabaseCount('apartments', count($data));
        $this->assertDatabaseHas('apartments', ['id' => $data[0]['id']]);
    }

    public function test_parser_xml_save_throw()
    {
        $this->withoutExceptionHandling();
        $badData = [
            ['id' => 10]
        ];

        $this->expectException(QueryException::class);
        $this->xmlParserService->saveData($badData);
    }
}
