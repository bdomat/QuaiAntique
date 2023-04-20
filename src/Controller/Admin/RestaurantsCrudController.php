<?php

namespace App\Controller\Admin;

use App\Entity\Restaurants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RestaurantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Restaurants::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
