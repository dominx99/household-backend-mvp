<?php

namespace App\Auth\Domain;

use App\Household\Groups\Domain\Group;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
#[ORM\UniqueConstraint(name: 'email_uidx', columns: ['email'])]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Unique()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\ManyToMany(targetEntity: Group::class, mappedBy: 'users')]
    private Collection $userGroups;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(Group $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups[] = $userGroup;
            $userGroup->addUser($this);
        }

        return $this;
    }

    public function removeUserGroup(Group $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            $userGroup->removeUser($this);
        }

        return $this;
    }
}
