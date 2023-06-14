<?php

declare(strict_types=1);

namespace Tests\Full\CuyzVelinorDto;

use Tests\Full\CuyzVelinorDto\Address\AddressClean;

class PurchaseDto
{
    /** @var list<ProductDto> */
    public array $products;

    /** @var UserDto $user */
    public UserDto $user;

    public AddressClean $address;

    public string $createdAt;
}
