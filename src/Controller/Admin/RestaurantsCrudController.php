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
            ->setEntityLabelInPlural('Capacité maximale')
            ->setEntityLabelInSingular('Capacité maximale');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('guest_threshold', 'Nombre de convives maximum'),
        ];
    }
}
