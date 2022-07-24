<?php

declare(strict_types=1);

namespace App\Household\ShoppingListItems\Http;

use App\Household\ShoppingListItems\Application\Create\ShoppingListItemCreator;
use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Shared\Http\Symfony\ApiController;
use App\Shared\Http\Symfony\SuccessResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use function Lambdish\Phunctional\apply;

final class ShoppingListItemsPostController extends ApiController
{
    #[Route('api/v1/shopping-lists/{shoppingListId}/items')]
    #[ParamConverter('item', converter: 'fos_rest.request_body')]
    public function __invoke(
        ConstraintViolationListInterface $violations,
        ShoppingListItem $item,
        ShoppingListItemCreator $creator,
        string $shoppingListId
    ): Response {
        $violations->count() > 0
            ? $this->throwValidationFailedError($violations)
            : apply($creator, [$item, $shoppingListId]);

        return new SuccessResponse();
    }
}
