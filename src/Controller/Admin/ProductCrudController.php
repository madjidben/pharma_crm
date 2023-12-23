<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('category')
            ->setRequired(false),
            AssociationField::new('representatives','Medical Representatives')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
            AssociationField::new('productForms','Product Forms')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(), 
        ];
    }

}
