<?php

declare(strict_types=1);

namespace Tests\Full\SpatieDto;


use Spatie\DataTransferObject\DataTransferObject;
use Tests\Full\SpatieDto\Address\AddressClean;

class PurchaseDto extends DataTransferObject
{
    /** @var array<ProductDTO>  */
    public array $products;

    /** @var UserDto $user */
    public UserDto $user;

    /** @var AddressClean $user */
    public AddressClean $address;

    public string $createdAt;
}
