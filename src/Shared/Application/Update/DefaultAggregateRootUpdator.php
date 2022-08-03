<?php

declare(strict_types=1);

namespace App\Shared\Application\Update;

use Doctrine\ORM\EntityManagerInterface;

final class DefaultAggregateRootUpdator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    // TODO: Change type to aggregate root
    public function __invoke(mixed $aggregateRoot): void
    {
        $this->entityManager->persist($aggregateRoot);
        $this->entityManager->flush();
    }
}
