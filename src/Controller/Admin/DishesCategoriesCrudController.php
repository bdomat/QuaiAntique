<?php

namespace App\Controller\Admin;

use App\Entity\DishesCategories;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DishesCategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DishesCategories::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Catégories')
            ->setEntityLabelInSingular(label: 'Catégorie');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Titre de la catégorie')
        ];
    }
}
