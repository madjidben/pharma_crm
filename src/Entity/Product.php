<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'products',cascade: ['persist'])]
    private ?ProductCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'managedProducts',cascade: ['persist'])]
    private ?Position $manager = null;

    #[ORM\ManyToMany(targetEntity: Position::class, inversedBy: 'representedProducts',cascade: ['persist'])]
    private Collection $representatives;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductForm::class,cascade: ['persist'])]
    private Collection $productForms;

    public function __construct()
    {
        $this->representatives = new ArrayCollection();
        $this->productForms = new ArrayCollection();
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

    public function getCategory(): ?ProductCategory
    {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): static
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, ProductForm>
     */
    public function getProductForms(): Collection
    {
        return $this->productForms;
    }

    public function addProductForm(ProductForm $productForm): static
    {
        if (!$this->productForms->contains($productForm)) {
            $this->productForms->add($productForm);
            $productForm->setProduct($this);
        }

        return $this;
    }

    public function removeProductForm(ProductForm $productForm): static
    {
        if ($this->productForms->removeElement($productForm)) {
            // set the owning side to null (unless already changed)
            if ($productForm->getProduct() === $this) {
                $productForm->setProduct(null);
            }
        }

        return $this;
    }
    public function setProductForms(Collection $productForms): static
    {
        $this->productForms = $productForms;
        foreach ($this->productForms as $productForm) {
            $productForm->setProduct($this);
          }

        return $this;
    }

}
