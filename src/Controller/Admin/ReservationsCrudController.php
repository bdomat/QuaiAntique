<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural(label: 'Réservations')
            ->setEntityLabelInSingular(label: 'Réservation')
            ->setDefaultSort(sortFieldsAndOrder: ['id' => 'desc']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new(propertyName: 'reservation_name', label: 'Nom de l\'interlocuteur'),
            TelephoneField::new(propertyName: 'reservation_phone', label: 'Téléphone'),
            IntegerField::new(propertyName: 'guests_number', label: 'Nombre de convives'),
            DateTimeField::new(propertyName: 'date_time', label: 'Jour et horaire de réservation')
        ];
    }
}
