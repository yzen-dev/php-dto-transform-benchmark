<?php

declare(strict_types=1);

namespace Tests\Lite\SpatieDTO;

use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use Spatie\DataTransferObject\DataTransferObject;

class PurchaseDTO extends DataTransferObject
{
    #[CastListToType(ProductDTO::class)]
    public array $products;

    /** @var UserDTO $user */
    public UserDTO $user;
}
