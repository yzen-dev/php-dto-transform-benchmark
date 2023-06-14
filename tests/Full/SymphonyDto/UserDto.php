<?php
declare(strict_types=1);

namespace Tests\Full\SymphonyDto;

class UserDto
{
    public int $id;
    
    public string $type;
    
    public ?string $email;
    
    public float $balance;
    
    public string $createdAt;

    
    public string $real_address;
}
