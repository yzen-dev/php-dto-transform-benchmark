<?php

declare(strict_types=1);

namespace Tests\Benchmark\EventSauceDTO;

use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class PurchaseDTO
{
    public function __construct(
        public UserDTO $user,
        #[CastListToType(ProductDTO::class)]
        /** @var array */
        public array $products
    )
    {
    }

}
