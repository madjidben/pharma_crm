<?php

namespace App\Controller\Admin;

use App\Entity\ProductForm;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ProductFormCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductForm::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('product')
            ->setRequired(false),
        ];
    }
  
}
