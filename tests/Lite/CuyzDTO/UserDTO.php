<?php
declare(strict_types=1);

namespace Tests\Lite\CuyzDTO;


class UserDTO
{
    public int $id;
    public string $type;
    public ?string $email;
    public float $balance;
    public string $real_address;
}
