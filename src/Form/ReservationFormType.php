<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservation_name', TextType::class, [
                'label' => 'Réserver au nom de :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('reservation_phone', TextType::class, [
                'label' => 'Téléphone :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('guests_number', IntegerType::class, [
                'label' => 'Nombre de convives:',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('date_time', DateTimeType::class, [
                'label' => 'Date et heure de réservation:',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Form options
        ]);
    }
}
