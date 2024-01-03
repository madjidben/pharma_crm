<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WilayaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WilayaRepository::class)]
#[ApiResource]
class Wilaya
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'dataEntryWilayas',cascade: ['persist'])]
    private ?Position $dataEntryManager = null;

    #[ORM\ManyToMany(targetEntity: Position::class, inversedBy: 'representedWilayas',cascade: ['persist'])]
    private Collection $representatives;

    public function __construct()
    {
        $this->representatives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDataEntryManager(): ?Position
    {
        return $this->dataEntryManager;
    }

    public function setDataEntryManager(?Position $dataEntryManager): static
    {
        $this->dataEntryManager = $dataEntryManager;

        return $this;
    }

    public function __toString()
    {
        return 
        $this->getCode().
        "-".
        $this->getName() ;
    }

    //-------------------------New

    /**
     * @return Collection<int, Position>
     */
    public function getRepresentatives(): Collection
    {
        return $this->representatives;
    }

    public function addRepresentative(Position $representative): static
    {
        if (!$this->representatives->contains($representative)) {
            $this->representatives->add($representative);
        }

        return $this;
    }

    public function removeRepresentative(Position $representative): static
    {
        $this->representatives->removeElement($representative);

        return $this;
    }
}
