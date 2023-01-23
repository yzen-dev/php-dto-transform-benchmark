<?php

declare(strict_types=1);

namespace Tests\Benchmark\SpatieDTO;

use Spatie\DataTransferObject\DataTransferObject;

class PurchaseDTO extends DataTransferObject
{
    /** @var array<ProductDTO>  */
    public array $products;

    /** @var UserDTO $user */
    public UserDTO $user;
}
