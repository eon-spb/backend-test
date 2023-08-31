<?php

declare(strict_types=1);

namespace EON\Console\Commands;

use DOMDocument;
use Illuminate\Support\Str;

class TestXMLCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected $signature = 'test-xml:create';

    /**
     * @inheritdoc
     */
    protected $description = 'Command to create a test xml';

    /**
     * @inheritdoc
     */
    public function handle(): int
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $data = $dom->createElement('data');
        $xmlApartments = $dom->createElement('apartments');

        for ($i = 0; $i < 500_000; $i++) {
            $xmlApartment = $dom->createElement('apartment');
            $xmlApartment->setAttribute('id', Str::uuid()->toString());
            $xmlApartment->setAttribute('s_total', number_format(random_int(5, 500), 2, '.', ''));
            $xmlApartment->setAttribute('s_living', number_format(random_int(5, 400), 2, '.', ''));
            $xmlApartment->setAttribute('s_kitchen', number_format(random_int(5, 200), 2, '.', ''));
            $xmlApartment->setAttribute('height', random_int(0, 1) ? (string)random_int(1, 15) : '');
            $xmlApartment->setAttribute('price', number_format(random_int(4_000_000, 999_999_999), 2, '.', ''));
            if (random_int(0, 1)) {
                $xmlApartment->setAttribute('floor', (string)random_int(1, 50));
            }

            $xmlApartments->appendChild($xmlApartment);
        }

        $data->appendChild($xmlApartments);
        $dom->appendChild($data);
        $dom->save(storage_path('tmp/test.xml'));

        return self::SUCCESS;
    }
}
