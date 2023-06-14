<?php

declare(strict_types=1);

namespace Tests\Full\SpatieDto\Address;

use Spatie\DataTransferObject\DataTransferObject;

class MetroDto extends DataTransferObject
{
    public float $distance;

    public string $line;

    public string $name;
}
