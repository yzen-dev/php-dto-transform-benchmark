<?php
declare(strict_types=1);

namespace Tests\Full\SpatieDto;

use ClassTransformer\Attributes\FieldAlias;
use ClassTransformer\Attributes\WritingStyle;
use DateTimeImmutable;
use Spatie\DataTransferObject\Attributes\DefaultCast;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;


class UserDto  extends DataTransferObject
{
    public int $id;
    
    public string $type;
    
    public ?string $email;
    
    public float $balance;
    
    public string $createdAt;
    
    public ?string $real_address;
}
