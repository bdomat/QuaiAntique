<?php

namespace App\Controller\Admin;

use App\Entity\Dishes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DishesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dishes::class;
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
