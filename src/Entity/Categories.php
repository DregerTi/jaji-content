<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
#[UniqueEntity('label', message: 'Cette catégorie existe déjà.')]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'categories')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Contents::class, mappedBy: 'categories')]
    private Collection $contents;

    #[ORM\Column(length: 50)]
    private ?string $iconReference = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCategory($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Contents>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Contents $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->addCategory($this);
        }

        return $this;
    }

    public function removeContent(Contents $content): self
    {
        if ($this->contents->removeElement($content)) {
            $content->removeCategory($this);
        }

        return $this;
    }

    public function getIconReference(): ?string
    {
        return $this->iconReference;
    }

    public function setIconReference(string $iconReference): self
    {
        $this->iconReference = $iconReference;

        return $this;
    }
}
