<?php

namespace EON\XML\Services;

ini_set('memory_limit', '-1');

use EON\XML\Contracts\XMLParserContract;
use XMLReader;

class XMLParserNative implements XMLParserContract
{

    private function getRaws(string $file)
    {
        $reader = new XMLReader();
        $reader->open($file);
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name === 'apartment') yield $reader;
        }
        $reader->close();
    }

    private function prepareRawData(string $file)
    {
        $createData = [];

        foreach ($this->getRaws($file) as $readerRaw) {
            $createData[] = [
                $readerRaw->getAttribute('id'),
                $readerRaw->getAttribute('s_total'),
                $readerRaw->getAttribute('s_living'),
                $readerRaw->getAttribute('s_kitchen'),
                (int)$readerRaw->getAttribute('height'),
                $readerRaw->getAttribute('price'),
                (int)$readerRaw->getAttribute('floor') ?? 0,
            ];
        }

        return $createData;
    }

    public function getApartmentData(string $file): array
    {
        return $this->prepareRawData($file);
    }
}
