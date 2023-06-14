<?php
declare(strict_types=1);

namespace Tests\Full\JanePhpDto;

use ClassTransformer\Attributes\FieldAlias;
use ClassTransformer\Attributes\WritingStyle;

class UserDto
{
    public int $id;
    
    public UserTypeEnum $type;
    
    public ?string $contact;
    
    public float $balance;
    
    /** @var \DateTime|null */
    public $createdAt;
    
    public string $realAddress;
}

