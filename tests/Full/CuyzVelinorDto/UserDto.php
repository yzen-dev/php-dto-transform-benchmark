<?php
declare(strict_types=1);

namespace Tests\Full\CuyzVelinorDto;

use ClassTransformer\Attributes\FieldAlias;
use ClassTransformer\Attributes\WritingStyle;

class UserDto
{
    public int $id;
    
    public string $type;
    
    public ?string $contact;
    
    public float $balance;
    
    public string $createdAt;
    
    public string $realAddress;
}

