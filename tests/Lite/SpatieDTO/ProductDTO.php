<?php

declare(strict_types=1);

namespace Tests\Lite\SpatieDTO;

use Spatie\DataTransferObject\DataTransferObject;

class ProductDTO extends DataTransferObject
{
    public int $id;
    public string $name;
    public float $price;
    public string $description;
    public int $count;
}
