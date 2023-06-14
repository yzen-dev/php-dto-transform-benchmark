<?php

namespace Tests\Lite\YiiSoft;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

final class NotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct(private string $id)
    {
        parent::__construct("No definition or class found for \"$id\".");
    }

    public function getId(): string
    {
        return $this->id;
    }
}
