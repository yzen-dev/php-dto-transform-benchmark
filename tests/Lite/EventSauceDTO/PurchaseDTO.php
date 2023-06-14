<?php

declare(strict_types=1);

namespace Tests\Lite\EventSauceDTO;

use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use Tests\Lite\UserDTO;

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
