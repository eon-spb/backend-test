<?php

namespace Tests\Unit\Commands;

use Database\Factories\ApartmentFactory;
use EON\Http\Contracts\AbstractParser;
use PHPUnit\Framework\TestCase;

class XmlParserTest extends TestCase
{
    private AbstractParser $testParserClass;
    protected function setUp(): void
    {
        parent::setUp();

        /**
         * Новый анонимный класс
         * Позволяет реализовать логику для парсинга других типов данных, валидации, сохранения
         */
        $this->testParserClass = new class extends AbstractParser
        {
            public int $countData = 50;
            public int $chunkSize = 5;
            public function getData(string $path): iterable
            {
                $id = 0;
                return ApartmentFactory::new()->count($this->countData)->make([
                    'id' => function () use(&$id) {
                        return ++$id;
                    }
                ])->toArray();
            }

            public function saveData($data): bool
            {
                return true;
            }

            public function validation($data): mixed
            {
                return $data;
            }
        };
    }

    // Тестирование генератора
    public function test_parser_generator(): void
    {
        $data = $this->testParserClass->getData('path');

        $countCircle = 0;

        foreach ($this->testParserClass->generator($data, $this->testParserClass->chunkSize) as $chunk) {
            $countCircle++;
        }

        $this->assertEquals($countCircle, $this->testParserClass->countData/$this->testParserClass->chunkSize);
    }

    // Тестирование генератора с массивом данных
    public function test_parser_generator_array(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        $countCircle = 0;

        foreach ($this->testParserClass->generator($data, $this->testParserClass->chunkSize) as $chunk) {
            $countCircle++;
        }

        $this->assertEquals($countCircle, count($data)/$this->testParserClass->chunkSize);
    }

    // Тестирование генератора с коллекцией данных
    public function test_parser_generator_collect(): void
    {
        $data = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $countCircle = 0;

        foreach ($this->testParserClass->generator($data, $this->testParserClass->chunkSize) as $chunk) {
            $countCircle++;
        }

        $this->assertEquals($countCircle, count($data)/$this->testParserClass->chunkSize);
    }
}
