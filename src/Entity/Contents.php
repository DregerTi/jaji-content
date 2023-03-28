<?php

namespace App\Entity;

use App\Entity\Traits\BlameableTrait;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\ContentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: ContentsRepository::class)]
class Contents
{
    use TimestampableTrait;
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Expression(
        expression: "this.getType() == 'Article' ? this.getPrewiewImg() != null : true",
        message: "Vous devez ajouter une image de prévisualisation pour les articles"
    )]
    private ?string $prewiew_img = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 50)]
    #[Choice(choices: ['YouTube', 'Spotify', 'Deezer', 'Article'])]
    private ?string $type = null;

    #[ORM\Column(length: 350, nullable: true)]
    #[Expression(
        expression: "this.getType() == 'Article' ? this.getSrc() == null : this.getSrc() != null",
        message: "Vous ne pouvez pas ajouter de lien pour les articles"
    )]
    private ?string $src = null;

    #[ORM\ManyToMany(targetEntity: Offers::class, inversedBy: 'contents')]
    private Collection $offers;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: Favorites::class)]
    private Collection $favorites;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'contents')]
    private Collection $categories;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message: "La description ne peut pas être vide")]
    private ?string $description = null;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrewiewImg(): ?string
    {
        return $this->prewiew_img;
    }

    public function setPrewiewImg(?string $prewiew_img): self
    {
        $this->prewiew_img = $prewiew_img;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(?string $src): self
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return Collection<int, Offers>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offers $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
        }

        return $this;
    }

    public function removeOffer(Offers $offer): self
    {
        $this->offers->removeElement($offer);

        return $this;
    }

    /**
     * @return Collection<int, Favorites>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorites $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setContent($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getContent() === $this) {
                $favorite->setContent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
