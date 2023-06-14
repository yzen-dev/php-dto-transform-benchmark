<?php

declare(strict_types=1);

namespace Tests\Full\SymphonyDto;

use Tests\Full\SymphonyDto\Address\AddressClean;

class PurchaseDto
{
    /** @var array<ProductDto>|ProductDto[] */
    public array $products;

    /** @var UserDto $user */
    public UserDto $user;

    public AddressClean $address;

    public string $createdAt;
}
