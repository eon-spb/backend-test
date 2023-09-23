<?php

namespace EON\XML\Contracts;

use SimpleXMLElement;

interface XMLParserContract
{
    public function getApartmentData(string $file): array;
}
