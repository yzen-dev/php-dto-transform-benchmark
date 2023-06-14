<?php

declare(strict_types=1);

namespace Tests\Full\EventSauceDto;

use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;
use Tests\Full\EventSauceDto\Address\AddressClean;

class PurchaseDto
{
    public function __construct(
        #[CastListToType(ProductDTO::class)]
        public array $products,
        public UserDto $user,
        public AddressClean $address,
        #[CastToDateTimeImmutable('Y-m-d H:i:s')]
        public ?\DateTime $createdAt
    ) {
    }
}
