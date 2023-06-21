<?php
declare(strict_types=1);

namespace Tests\Full\NutgramDto;

use SergiX44\Hydrator\Annotation\Alias;

class UserDto
{
    public int $id;
    
    public UserTypeEnum $type;
    
    #[Alias('contact')]
    public ?string $email;
    
    public float $balance;
    
    public \DateTime $createdAt;

    #[Alias('realAddress')]
    public string $real_address;
}
