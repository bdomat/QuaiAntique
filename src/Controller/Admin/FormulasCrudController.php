<?php

namespace App\Controller\Admin;

use App\Entity\Formulas;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormulasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formulas::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Formules')
            ->setEntityLabelInSingular(label: 'Formule');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new(propertyName: 'title', label: 'Composition de la formule'),
            AssociationField::new(propertyName: 'menu', label: 'Menu associé'),
            MoneyField::new(propertyName: 'price', label: 'Prix')->setCurrency('EUR'),
        ];
    }
}
