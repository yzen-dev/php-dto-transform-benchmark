<?php

declare(strict_types=1);

namespace Tests\Lite\NutgramDTO;

use SergiX44\Hydrator\Annotation\ArrayType;

class PurchaseDTO
{
    #[ArrayType(ProductDTO::class)]
    public array $products;
    
    public UserDTO $user;
}
