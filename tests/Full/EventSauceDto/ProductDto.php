<?php

declare(strict_types=1);

namespace Tests\Full\EventSauceDto;

class ProductDto
{
    public function __construct(
        public int $id,
        public string $name,
        public float $price,
        public string $description,
        public int $count,
    ) {
    }

}
