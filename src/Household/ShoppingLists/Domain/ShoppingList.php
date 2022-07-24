<?php

namespace App\Household\ShoppingLists\Domain;

use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Household\Groups\Domain\Group;

#[ORM\Entity(repositoryClass: ShoppingListRepository::class)]
class ShoppingList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'shoppingLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $shoppingListGroup = null;

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

    public function getShoppingListGroup(): ?Group
    {
        return $this->shoppingListGroup;
    }

    public function setShoppingListGroup(?Group $shoppingListGroup): self
    {
        $this->shoppingListGroup = $shoppingListGroup;

        return $this;
    }
}
