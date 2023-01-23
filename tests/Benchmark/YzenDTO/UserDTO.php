<?php
declare(strict_types=1);

namespace Tests\Benchmark\YzenDTO;

use ClassTransformer\Attributes\WritingStyle;

class UserDTO
{
    public int $id;
    public string $type;
    public ?string $email;
    public float $balance;

    #[WritingStyle(WritingStyle::STYLE_CAMEL_CASE)]
    public string $real_address;
}
