<?php

declare(strict_types=1);

namespace EON\Console\Commands;

use DOMDocument;
use Faker\Core\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TestXMLParseCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected $signature = 'test-xml:parse';

    /**
     * @inheritdoc
     */
    protected $description = 'Command to parse a test xml';

    /**
     * @inheritdoc
     */
    public function handle(): int
    {
        try{
            $file = fopen(storage_path('tmp/test.xml'), 'r');
            fgets($file);
            fgets($file, 19);
            $res = '';
            for ($i = 0; $i < 25; $i++) {
                $parameters = array(
                    "id" => "NULL",
                    "s_total" => "NULL",
                    "s_living" => "NULL",
                    "s_kitchen" => "NULL",
                    "height" => "NULL",
                    "price" => "NULL",
                    "floor" => "NULL"
                );
                if (!str_contains($res, '>')) {
                    $arr = explode('>', fgets($file, 200));
                    $res .= $arr[0] . '>';
                } else {
                    $arr = explode('>', $res);
                    $res = $arr[0] . '>';
                }
                $next = isset($arr[2]) ? $arr[1] . '>' . $arr[2] : $arr[1];

                $res = explode(" ", substr($res, 1, -2));
                foreach ($res as $value) {
                    if (!str_contains($value, '=')) continue;
                    $value = explode("=", $value);
                    if ($value[1] != '""') {
                        $parameters[$value[0]] = "'" . trim($value[1], '\"') . "'";
                    }
                }
                $query = 'INSERT INTO apartments (id, s_total, s_living, s_kitchen, height, price, floor) VALUES (' . $parameters["id"] . ', ' . $parameters["s_total"] . ', ' . $parameters["s_living"] . ', ' . $parameters["s_kitchen"] . ', ' . $parameters["height"] . ', ' . $parameters["price"] . ', ' . $parameters["floor"] . ')';
                DB::insert($query);
                $res = $next;
            }
            return self::SUCCESS;
        } catch (\Exception $e){
            echo $e->getMessage();
            return self::FAILURE;
        }
    }
}
