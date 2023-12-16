<?php

namespace EON\Http\Contracts;

abstract class AbstractParser implements ParserContract
{
    /**
     * Генерирует chunks данных заданного размера
     * Возвращает остаток, если chunk не заполнился
     *
     * @param iterable $data      Данные для парсинга
     * @param int      $chunkSize Размер чанка данных (по умолчанию 500)
     * @return iterable Chunk данных в виде итерируемого объекта
     */
    public function generator(iterable $data, int $chunkSize=500): iterable
    {
        $chunk = [];

        foreach ($data as $element) {
            $element = $this->validation($element);
            $chunk[] = $element;

            if (count($chunk) === $chunkSize) {
                yield $chunk;
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            yield $chunk;
        }
    }

    /**
     * Получает значение пика использования памяти в мегабайтах.
     *
     * @return int
     */
    public function memoryPeakUsage(): int
    {
        gc_collect_cycles();
        $memoryPeakUsage = memory_get_peak_usage();
        return round($memoryPeakUsage / 1024 / 1024, 2);
    }

    /**
     * Получает текущее использование памяти в мегабайтах
     *
     * @return int
     */
    public function memoryUsage(): int
    {
        gc_collect_cycles();
        $memoryUsage = memory_get_usage();
        return round($memoryUsage / 1024 / 1024, 2);
    }
}
