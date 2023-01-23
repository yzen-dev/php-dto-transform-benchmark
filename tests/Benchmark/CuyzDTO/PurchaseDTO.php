<?php

declare(strict_types=1);

namespace Tests\Benchmark\CuyzDTO;

class PurchaseDTO
{
    /** @var array<ProductDTO> */
    public array $products;

    /** @var UserDTO $user */
    public UserDTO $user;
}
