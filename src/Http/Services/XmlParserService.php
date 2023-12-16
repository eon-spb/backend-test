<?php

namespace EON\Http\Services;

use EON\Http\Contracts\AbstractParser;
use Illuminate\Support\Facades\DB;

class XmlParserService extends AbstractParser
{
    /**
     * Путь к XML файлу по умолчанию
     *
     * @var string
     */
    public string $path = '/tmp/test.xml';

    /**
     * Получение данных из XML-файла
     *
     * @param string $path Путь к XML-файлу
     * @return iterable Данные в виде итерируемого объекта
     */
    public function getData(string $path): iterable
    {
        $xml = simplexml_load_file($path);

        return $xml->apartments->apartment;
    }

    /**
     * Сохранение данных
     *
     * @param mixed $data Данные для сохранения
     * @return bool Возвращает true в случае успешного сохранения
     * @throws \Throwable
     */
    public function saveData($data): bool
    {
        DB::beginTransaction();
        try {
            DB::table('apartments')->upsert($data, 'id');
            DB::commit();
        }catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Проверяет и преобразует данные перед сохранением в базу данных
     * Если в проверке нет необходимости, то можно вернуть данные без изменений
     *
     * @param mixed $data Данные для валидации
     * @return mixed Возвращает массив данных после валидации
     */
    public function validation($data): mixed
    {
        $dataArray['id'] = $data->attributes()->id;
        $dataArray['s_total'] = $data->attributes()->s_total;
        $dataArray['s_living'] = $data->attributes()->s_living;
        $dataArray['s_kitchen'] = $data->attributes()->s_kitchen;
        if (isset($data->attributes()->height) && is_numeric((int)$data->attributes()->height)) {
            $dataArray['height'] = (int) $data->attributes()->height;
        } else {
            $dataArray['height'] = 0;
        }
        $dataArray['price'] = (float) $data->attributes()->price;
        $dataArray['floor'] = (int) $data->attributes()->floor;

        return $dataArray;
    }
}
