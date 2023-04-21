<?php

namespace App\Controller\Admin;

use App\Entity\Restaurants;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class RestaurantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurants::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Informations restaurant')
            ->setEntityLabelInSingular(label: 'Information restaurant');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new(propertyName: 'guest_threshold', label: 'Nombre de convives maximum'),
        ];
    }
}
