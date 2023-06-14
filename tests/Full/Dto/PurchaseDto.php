<?php

declare(strict_types=1);

namespace Tests\Full\Dto;

use ClassTransformer\Attributes\ConvertArray;
use Tests\Full\Dto\Address\AddressClean;

class PurchaseDto
{
    #[ConvertArray(ProductDto::class)]
    /** @var array<ProductDto> */
    public array $products;

    /** @var UserDto $user */
    public UserDto $user;

    public AddressClean $address;

    public \DateTime $createdAt;
}
