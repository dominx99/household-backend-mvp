<?php

declare(strict_types=1);

namespace App\Household\ShoppingListItems\Http;

use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Shared\Application\Update\DefaultAggregateRootUpdator;
use App\Shared\Http\Symfony\ApiController;
use App\Shared\Http\Symfony\SuccessResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use function Lambdish\Phunctional\apply;

final class ShoppingListItemPutController extends ApiController
{
    #[Route('api/v1/shopping-list-items/{shoppingListItemId}', methods: ['PUT'])]
    #[ParamConverter('item', converter: 'fos_rest.request_body', options: [
        'validator' => [
            'groups' => ['PUT'],
        ],
    ])]
    public function __invoke(
        ConstraintViolationListInterface $violations,
        ShoppingListItem $item,
        DefaultAggregateRootUpdator $updator
    ): JsonResponse {
        $violations->count() > 0
            ? $this->throwValidationFailedError($violations)
            : apply($updator, [$item]);

        return new SuccessResponse();
    }
}
