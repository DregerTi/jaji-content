<?php

namespace App\Entity\Traits;

use App\Entity\Users;
use Gedmo\Mapping\Annotation\Blameable;
use Doctrine\ORM\Mapping as ORM;

trait BlameableTrait
{
    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[Blameable(on: 'create')]
    private ?Users $createdBy = null;

    #[ORM\ManyToOne(targetEntity: Users::class)]
    #[Blameable(on: 'update')]
    private ?Users $updatedBy = null;

    /**
     * @return Users|null
     */
    public function getCreatedBy(): ?Users
    {
        return $this->createdBy;
    }

    /**
     * @param Users|null $createdBy
     * @return self
     */
    public function setCreatedBy(?Users $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return Users|null
     */
    public function getUpdatedBy(): ?Users
    {
        return $this->updatedBy;
    }

    /**
     * @param Users|null $updatedBy
     * @return self
     */
    public function setUpdatedBy(?Users $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }
}