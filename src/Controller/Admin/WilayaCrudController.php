<?php

namespace App\Controller\Admin;

use App\Entity\Wilaya;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class WilayaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wilaya::class;
    }

 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setFormTypeOptions(['disabled'=>true]),
            TextField::new('code')->setFormTypeOptions(['disabled'=>true]),
            TextField::new('name')->setFormTypeOptions(['disabled'=>true]),
            AssociationField::new('dataEntryManager')
            ->setRequired(false),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;
    }

}
