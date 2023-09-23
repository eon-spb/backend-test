<?php

namespace EON\XML\Services;

use EON\XML\Contracts\XMLParserContract;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;

class XMLParserNative implements XMLParserContract
{

    private function getRaws(string $file): SimpleXMLElement
    {
        $fileDataRaws = File::get($file);
        return new SimpleXMLElement($fileDataRaws);
    }

    public function getApartmentData(string $file): array
    {
        $simpleXMLElement = $this->getRaws($file);
        return [];
    }
}
