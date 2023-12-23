<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PositionRepository::class)]
#[ApiResource]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'positions',cascade: ['persist'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: BusinessUnit::class,cascade: ['persist'])]
    private Collection $businessUnits;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Team::class,cascade: ['persist'])]
    private Collection $teams;

    #[ORM\ManyToOne(inversedBy: 'positions',cascade: ['persist'])]
    private ?Team $team = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Product::class,cascade: ['persist'])]
    private Collection $managedProducts;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'representatives',cascade: ['persist'])]
    private Collection $representedProducts;

    #[ORM\OneToMany(mappedBy: 'dataEntryManager', targetEntity: Wilaya::class,cascade: ['persist'])]
    private Collection $dataEntryWilayas;

    public function __construct()
    {
        $this->businessUnits = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->managedProducts = new ArrayCollection();
        $this->representedProducts = new ArrayCollection();
        $this->dataEntryWilayas = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
      
        return $this;
    }

    public function __toString()
    {
        return 
        $this->getName()
        ." (".$this->getType().")"
        ;
    }

    /**
     * @return Collection<int, BusinessUnit>
     */
    public function getBusinessUnits(): Collection
    {
        return $this->businessUnits;
    }

    public function addBusinessUnit(BusinessUnit $businessUnit): static
    {
        if (!$this->businessUnits->contains($businessUnit)) {
            $this->businessUnits->add($businessUnit);
            $businessUnit->setManager($this);
        }

        return $this;
    }

    public function removeBusinessUnit(BusinessUnit $businessUnit): static
    {
        if ($this->businessUnits->removeElement($businessUnit)) {
            // set the owning side to null (unless already changed)
            if ($businessUnit->getManager() === $this) {
                $businessUnit->setManager(null);
            }
        }

        return $this;
    }

    public function setBusinessUnits(Collection $businessUnits): static
    {
        $this->businessUnits = $businessUnits;
        foreach ($this->businessUnits as $businessUnit) {
            $businessUnit->setManager($this);
            // $this->addPosition($position);
          }

        return $this;
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
            $team->setManager($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getManager() === $this) {
                $team->setManager(null);
            }
        }

        return $this;
    }

    public function setTeams(Collection $teams): static
    {
        $this->teams = $teams;
        foreach ($this->teams as $team) {
            $team->setManager($this);
            // $this->addPosition($position);
          }

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getManagedProducts(): Collection
    {
        return $this->managedProducts;
    }

    public function addManagedProduct(Product $product): static
    {
        if (!$this->managedProducts->contains($product)) {
            $this->managedProducts->add($product);
            $product->setManager($this);
        }

        return $this;
    }

    public function removeManagedProduct(Product $product): static
    {
        if ($this->managedProducts->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getManager() === $this) {
                $product->setManager(null);
            }
        }

        return $this;
    }

    public function setManagedProducts(Collection $managedProducts): static
    {
        $this->managedProducts = $managedProducts;
        foreach ($this->managedProducts as $product) {
            $product->setManager($this);
          }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getRepresentedProducts(): Collection
    {
        return $this->representedProducts;
    }

    public function addRepresentedProduct(Product $representedProduct): static
    {
        if (!$this->representedProducts->contains($representedProduct)) {
            $this->representedProducts->add($representedProduct);
            $representedProduct->addRepresentative($this);
        }

        return $this;
    }

    public function removeRepresentedProduct(Product $representedProduct): static
    {
        if ($this->representedProducts->removeElement($representedProduct)) {
            $representedProduct->removeRepresentative($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Wilaya>
     */
    public function getDataEntryWilayas(): Collection
    {
        return $this->dataEntryWilayas;
    }

    public function addDataEntryWilaya(Wilaya $dataEntryWilaya): static
    {
        if (!$this->dataEntryWilayas->contains($dataEntryWilaya)) {
            $this->dataEntryWilayas->add($dataEntryWilaya);
            $dataEntryWilaya->setDataEntryManager($this);
        }

        return $this;
    }

    public function removeDataEntryWilaya(Wilaya $dataEntryWilaya): static
    {
        if ($this->dataEntryWilayas->removeElement($dataEntryWilaya)) {
            // set the owning side to null (unless already changed)
            if ($dataEntryWilaya->getDataEntryManager() === $this) {
                $dataEntryWilaya->setDataEntryManager(null);
            }
        }

        return $this;
    }
    public function setDataEntryWilayas(Collection $wilayas): static
    {
        $this->dataEntryWilayas = $wilayas;
        foreach ($this->dataEntryWilayas as $wilaya) {
            $wilaya->setDataEntryManager($this);
          }

        return $this;
    }
}
