<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;


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
                ],
                'data' => 1, // default value
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le nombre de convives doit être supérieur ou égal à zéro.'
                    ]),
                ],
            ])
            ->add('date_time', DateTimeType::class, [
                'label' => 'Date et heure de réservation:',
                'widget' => 'single_text',
                'attr' => [
                    'id' => 'reservation_form_date_time',
                    'class' => 'form-control',
                ],
                'minutes' => range(0, 45, 15), // 15 min slice selection
                'constraints' => [
                    new Callback([
                        'callback' => function ($date, ExecutionContextInterface $context) {
                            // Ensure future date and hour selection
                            if ($date instanceof \DateTimeInterface && $date < new \DateTime()) {
                                $context->buildViolation('La date et l\'heure de réservation doivent être futures.')
                                    ->addViolation();
                            }

                            // Ensure 15 min slice selection
                            $minutes = $date->format('i');
                            if ($minutes % 15 !== 0) {
                                $context->buildViolation('L\'horaire de réservation doit être une tranche de 15 minutes.')
                                    ->addViolation();
                            }
                        },
                    ]),
                ],
                'html5' => false, // Disable native calendar
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
