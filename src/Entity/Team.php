<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'teams',cascade: ['persist'])]
    private ?BusinessUnit $businessUnit = null;

    #[ORM\ManyToOne(inversedBy: 'teams',cascade: ['persist'])]
    private ?Position $manager = null;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Position::class,cascade: ['persist'])]
    private Collection $positions;

    public function __construct()
    {
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBusinessUnit(): ?BusinessUnit
    {
        return $this->businessUnit;
    }

    public function setBusinessUnit(?BusinessUnit $businessUnit): static
    {
        $this->businessUnit = $businessUnit;

        return $this;
    }

    public function __toString()
    {
        return 
        $this->getName();
    }

    public function getManager(): ?Position
    {
        return $this->manager;
    }

    public function setManager(?Position $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection<int, Position>
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): static
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->setTeam($this);
        }

        return $this;
    }

    public function removePosition(Position $position): static
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getTeam() === $this) {
                $position->setTeam(null);
            }
        }

        return $this;
    }

    public function setPositions(Collection $positions): static
    {
        $this->positions = $positions;
        foreach ($this->positions as $position) {
            $position->setUser($this);
            // $this->addPosition($position);
          }

        return $this;
    }
}
