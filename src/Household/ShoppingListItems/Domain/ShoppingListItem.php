<?php

namespace App\Household\ShoppingListItems\Domain;

use App\Household\ShoppingListItems\Infrastructure\Persistence\ShoppingListItemRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Household\ShoppingLists\Domain\ShoppingList;
use JMS\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ShoppingListItemRepository::class)]
class ShoppingListItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, options: ['default' => 'units'])]
    private ?string $unit = 'units';

    #[ORM\Column(type: 'integer', options: ['default' => 1])]
    private ?int $amount = 1;

    #[ORM\ManyToOne(inversedBy: 'shoppingListItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?ShoppingList $shoppingList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getShoppingList(): ?ShoppingList
    {
        return $this->shoppingList;
    }

    public function setShoppingList(?ShoppingList $shoppingList): self
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }
}
