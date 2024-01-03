<?php

namespace App\Controller\Admin;

use App\Entity\Position;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class PositionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Position::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            ChoiceField::new('type')->setChoices(array(
                'BUSINESS_UNIT_MANAGER'=>'BUSINESS_UNIT_MANAGER',
                'MEDICAL_TEAM_MANAGER'=>'MEDICAL_TEAM_MANAGER',
                'SALES_TEAM_MANAGER'=>'SALES_TEAM_MANAGER',
                'REPRESENTATIVE_KEY_ACCOUNT_MANAGER'=>'REPRESENTATIVE_KEY_ACCOUNT_MANAGER',
                'REPRESENTATIVE_PHARMA'=>'REPRESENTATIVE_PHARMA',
                'REPRESENTATIVE_MEDICAL'=>'REPRESENTATIVE_MEDICAL',
                'PRODUCT_MANAGER'=>'PRODUCT_MANAGER',
                'DATA_ENTRY_MANAGER'=>'DATA_ENTRY_MANAGER',
            )),
            AssociationField::new('user')
            ->setRequired(false),
            AssociationField::new('businessUnits','Business Units Manager')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
            AssociationField::new('teams','Representatives Teams Manager')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
            AssociationField::new('team','Representatives Teams Member')
            ->setRequired(false),
            AssociationField::new('managedProducts','Managed Products (Product Manager)')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
            AssociationField::new('representedProducts','Represented Products (Medical Representative)')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),
            AssociationField::new('representedWilayas','Represented Wilayas (Medical/Sales/Pharm Representative & KAM)')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(), 
            AssociationField::new('dataEntryWilayas','Data Entry Wilayas (Data Entry Manager)')
            ->setRequired(false)
            ->setFormTypeOptionIfNotSet('by_reference', false)
            ->hideOnIndex(),          
           
        ];
    }
   
}
