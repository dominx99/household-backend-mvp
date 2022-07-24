<?php

declare(strict_types=1);

namespace App\Shared\Http\Symfony;

use App\Shared\Domain\Utils;
use App\Shared\Domain\ValidationFailedError;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class ApiController
{
    public function throwValidationFailedError(ConstraintViolationListInterface $violations): void
    {
        throw new ValidationFailedError(Utils::formatViolations($violations));
    }
}
