<?php

namespace App\Entity;

use App\Repository\CodeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CodeRepository::class)
 */
class Code
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

     /**
      * @ORM\ManyToOne(targetEntity=Award::class, inversedBy="codes")
      * @ORM\JoinColumn(nullable=false)
      */
    private $award;

    /**
     * @ORM\Column(type="boolean")
     */
    private $awarded;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAwarded(): ?bool
    {
        return $this->awarded;
    }

    public function setAwarded(bool $awarded): self
    {
        $this->awarded = $awarded;

        return $this;
    }

    public function getAward(): ?Award
    {
        return $this->award;
    }

    public function setAward(?Award $award): self
    {
        $this->award = $award;

        return $this;
    }
}
