<?php

declare(strict_types=1);

namespace Tests\Full\EventSauceDto\Address;

use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

class MetroDto
{
    public function __construct(
        #[CastToType('float')]
        public float $distance,
        public string $line,
        public string $name
    ) {
    }


}
