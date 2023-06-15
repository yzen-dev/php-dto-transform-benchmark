<?php

declare(strict_types=1);

namespace Tests\Lite\YzenDto;

use ClassTransformer\Attributes\ConvertArray;

class PurchaseDTO
{
    #[ConvertArray(ProductDTO::class)]
    /** @var array<ProductDTO> */
    public array $products;

    /** @var UserDTO $user */
    public UserDTO $user;
}
