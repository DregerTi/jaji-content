<?php

namespace App\Entity;

use App\Repository\ContentOffersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentOffersRepository::class)]
class ContentOffers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_content = null;

    #[ORM\Column]
    private ?int $id_offer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdContent(): ?int
    {
        return $this->id_content;
    }

    public function setIdContent(int $id_content): self
    {
        $this->id_content = $id_content;

        return $this;
    }

    public function getIdOffer(): ?int
    {
        return $this->id_offer;
    }

    public function setIdOffer(int $id_offer): self
    {
        $this->id_offer = $id_offer;

        return $this;
    }
}
