<?php

namespace EON\XML\Actions;

use EON\XML\Contracts\XMLParserContract;

class XMLParseAction
{
    public function handle(string $file)
    {
        $data = app(XMLParserContract::class)->getApartmentData($file);
    }
}
