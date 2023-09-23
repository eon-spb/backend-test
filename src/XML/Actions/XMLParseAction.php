<?php

namespace EON\XML\Actions;

use EON\XML\Contracts\XMLParserContract;
use EON\XML\Repositories\ApartmentsRepository;

class XMLParseAction
{
    public function handle(string $file)
    {
        $apartments = app(XMLParserContract::class)->getApartmentData($file);
        foreach ($apartments as $apartment) app(ApartmentsRepository::class)->createApartment(...$apartment);
    }
}
