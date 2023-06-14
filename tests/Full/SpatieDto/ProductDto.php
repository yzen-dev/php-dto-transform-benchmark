<?php

declare(strict_types=1);

namespace Tests\Full\SpatieDto;

use Spatie\DataTransferObject\DataTransferObject;

class ProductDto extends DataTransferObject
{
    public int $id;
    public string $name;
    public float $price;
    public string $description;
    public int $count;
}
