<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Repository\SchedulesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ReservationFormType extends AbstractType
{
    private $schedulesRepository;

    public function __construct(SchedulesRepository $schedulesRepository)
    {
        $this->schedulesRepository = $schedulesRepository;
    }

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
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 0,
                        'message' => 'Le nombre de convives doit être supérieur ou égal à zéro.'
                    ]),
                ],
            ])
            ->add('allergies', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('date_time', DateTimeType::class, [
                'label' => 'Date et heure de réservation:',
                'widget' => 'single_text',
                'attr' => [
                    'id' => 'reservation_form_date_time',
                    'class' => 'form-control',
                    'placeholder' => 'Sélectionner une date et un horaire',
                ],
                'minutes' => range(0, 45, 15), // 15 min slice selection
                'constraints' => [
                    new Callback([
                        'callback' => function ($date, ExecutionContextInterface $context) use ($options) {
                            /** @var SchedulesRepository $schedulesRepository */
                            $schedulesRepository = $options['schedules_repository'];

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

                            // Check the selected day is available for booking
                            $days = [
                                1 => 'Lundi',
                                2 => 'Mardi',
                                3 => 'Mercredi',
                                4 => 'Jeudi',
                                5 => 'Vendredi',
                                6 => 'Samedi',
                                7 => 'Dimanche',
                            ];
                            $dayOfWeek = $days[$date->format('N')]; // 1 (for Monday) through 7 (for Sunday)
                            $schedule = $schedulesRepository->findOneBy(['day' => $dayOfWeek]);
                            if (!$schedule || !$schedule->isIsActive()) {
                                $context->buildViolation('Ce jour n\'est pas disponible pour la réservation.')
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

        $resolver->setRequired('schedules_repository'); // Add this line
    }
}
