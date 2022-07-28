<?php

declare(strict_types=1);

namespace App\Shared\Domain\Enum;

interface RegexConstants
{
    public const UUID = '^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$';
}
