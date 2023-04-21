<?php

namespace App\Controller\Admin;

use App\Entity\Dishes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DishesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dishes::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Plats')
            ->setEntityLabelInSingular(label: 'Plat');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new(propertyName: 'title', label: 'Intitulé'),
            TextareaField::new(propertyName: 'description', label: 'Composition du plat'),
            MoneyField::new(propertyName: 'price', label: 'Prix')->setCurrency('EUR'),
            AssociationField::new(propertyName: 'parent_category', label: 'Catégorie'),
        ];
    }
}
