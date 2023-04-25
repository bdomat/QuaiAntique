<?php

namespace App\Controller\Admin;

use App\Entity\Menus;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MenusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menus::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Menus')
            ->setEntityLabelInSingular(label: 'Menu');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new(propertyName: 'title', label: 'Intitulé'),
            TextField::new(propertyName: 'menu_entry', label: 'Entrée(s)'),
            TextField::new(propertyName: 'menu_main_course', label: 'Plat(s)'),
            TextField::new(propertyName: 'menu_dessert', label: 'Dessert(s)'),
        ];
    }
}
