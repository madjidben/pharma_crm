<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BusinessUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessUnitRepository::class)]
#[ApiResource]
class BusinessUnit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'businessUnits',cascade: ['persist'])]
    private ?Position $manager = null;

    #[ORM\OneToMany(mappedBy: 'businessUnit', targetEntity: Team::class,cascade: ['persist'])]
    private Collection $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
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

    public function getManager(): ?Position
    {
        return $this->manager;
    }

    public function setManager(?Position $manager): static
    {
        $this->manager = $manager;

        return $this;
    }

    public function __toString()
    {
        return 
        $this->getName();
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setBusinessUnit($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getBusinessUnit() === $this) {
                $team->setBusinessUnit(null);
            }
        }

        return $this;
    }

    public function setTeams(Collection $teams): static
    {
        $this->teams = $teams;
        foreach ($this->teams as $team) {
            $team->setBusinessUnit($this);
            // $this->addPosition($position);
          }

        return $this;
    }
}
