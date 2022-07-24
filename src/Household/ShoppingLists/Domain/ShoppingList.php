<?php

namespace App\Household\ShoppingLists\Domain;

use App\Household\ShoppingListItems\Domain\ShoppingListItem;
use App\Household\ShoppingLists\Infrastructure\Persistence\ShoppingListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
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
    #[MaxDepth(1)]
    private ?Group $shoppingListGroup = null;

    #[ORM\OneToMany(mappedBy: 'shoppingList', targetEntity: ShoppingListItem::class, orphanRemoval: true)]
    #[MaxDepth(1)]
    private Collection $shoppingListItems;

    public function __construct()
    {
        $this->shoppingListItems = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ShoppingListItem>
     */
    public function getShoppingListItems(): Collection
    {
        return $this->shoppingListItems;
    }

    public function addShoppingListItem(ShoppingListItem $shoppingListItem): self
    {
        if (!$this->shoppingListItems->contains($shoppingListItem)) {
            $this->shoppingListItems[] = $shoppingListItem;
            $shoppingListItem->setShoppingList($this);
        }

        return $this;
    }

    public function removeShoppingListItem(ShoppingListItem $shoppingListItem): self
    {
        if ($this->shoppingListItems->removeElement($shoppingListItem)) {
            // set the owning side to null (unless already changed)
            if ($shoppingListItem->getShoppingList() === $this) {
                $shoppingListItem->setShoppingList(null);
            }
        }

        return $this;
    }
}
