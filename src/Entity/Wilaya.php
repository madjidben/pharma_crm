<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WilayaRepository;
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
}
