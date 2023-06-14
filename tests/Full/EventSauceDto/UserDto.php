<?php
declare(strict_types=1);

namespace Tests\Full\EventSauceDto;

use ClassTransformer\Attributes\FieldAlias;
use ClassTransformer\Attributes\WritingStyle;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;

class UserDto
{

    public function __construct(
        public int $id,
        public UserTypeEnum $type,
        #[MapFrom('contact')]
        public ?string $email,
        public float $balance,
        #[CastToDateTimeImmutable('Y-m-d H:i:s')]
        public ?\DateTime $createdAt,
        public ?string $real_address
    ) {
    }


}
