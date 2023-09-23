<?php

declare(strict_types=1);

namespace EON\XML\Repositories;

use EON\Models\Apartments;
use EON\XML\Abstracts\Repositories;

class ApartmentsRepository extends Repositories
{
    public function createRepository(
        string $uaid,
        int $sTotal,
        int $sLiving,
        int $sKitchen,
        int $height,
        int $price,
        int $floor
    ): Apartments {
        return $this->create([
            'uaid' => $uaid,
            's_total' => $sTotal,
            's_living' => $sLiving,
            's_kitchen' => $sKitchen,
            'height' => $height,
            'price' => $price,
            'floor' => $floor,
        ]);
    }
}
