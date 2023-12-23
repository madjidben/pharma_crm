<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('businessUnit')
            ->setRequired(false),
            AssociationField::new('manager')
            ->setRequired(false),
            AssociationField::new('positions','Team Members (Representatives)')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
        ];
    }
  
}
