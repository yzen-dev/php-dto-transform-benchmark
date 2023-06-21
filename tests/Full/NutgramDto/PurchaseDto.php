<?php

declare(strict_types=1);

namespace Tests\Full\NutgramDto;

use SergiX44\Hydrator\Annotation\ArrayType;
use Tests\Full\NutgramDto\Address\AddressClean;

class PurchaseDto
{
    #[ArrayType(ProductDto::class)]
    public array $products;
    
    public UserDto $user;

    public AddressClean $address;

    public \DateTime $createdAt;
}
