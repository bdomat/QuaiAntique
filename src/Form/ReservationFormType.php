<?php

namespace App\Form;

use App\Entity\Reservations;
use App\Repository\SchedulesRepository;
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
    private $schedulesRepository;

    public function __construct(SchedulesRepository $schedulesRepository)
    {
        $this->schedulesRepository = $schedulesRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $schedules = $this->schedulesRepository->findAll();

        foreach ($schedules as $schedule) {
            $day = strtolower($schedule->getDay());

            $builder->add($day, DateTimeType::class, [
                'label' => 'Date et heure de réservation pour ' . ucfirst($day) . ':',
                'widget' => 'single_text',
                'attr' => [
                    'id' => 'reservation_form_' . $day,
                    'class' => 'form-control',
                ],
                'html5' => false,
                'constraints' => [
                    new Callback([$this, 'validateDateTime']),
                ],
                'data' => new \DateTime('today ' . $schedule->getOpeningHour()->format('H:i')),
            ]);
        }

        $builder->add('reservation_name', TextType::class, [
            'label' => 'Nom:',
            'attr' => [
                'class' => 'form-control',
            ],
        ])
            ->add('reservation_phone', TextType::class, [
                'label' => 'Téléphone:',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('guests_number', IntegerType::class, [
                'label' => 'Nombre de convives:',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new GreaterThanOrEqual(1),
                ],
            ]);
    }

    public function validateDateTime($dateTime, ExecutionContextInterface $context)
    {
        // verify if dateTime is define
        if ($dateTime === null) {
            return;
        }

        // verify if datetime is in future
        if ($dateTime < new \DateTime()) {
            $context->buildViolation('La date et l\'heure de réservation doivent être futures.')
                ->addViolation();
        }

        // verify 15min slice
        $minutes = (int) $dateTime->format('i');
        if ($minutes % 15 !== 0) {
            $context->buildViolation('L\'horaire de réservation doit être une tranche de 15 minutes.')
                ->addViolation();
        }

        // get reservation day
        $reservationDay = strtolower($dateTime->format('l'));

        // get hours by day
        $schedule = $this->schedulesRepository->findOneBy(['day' => $reservationDay]);

        // verify if schedule is available
        if (!$schedule) {
            $context->buildViolation('Les horaires d\'ouverture pour ' . ucfirst($reservationDay) . ' ne sont pas disponibles.')
                ->addViolation();
        } else {
            // compare opening schedule with reservation time
            $openingHour = $schedule->getOpeningHour();
            $closingHour = $schedule->getClosingHour();
            $reservationTime = $dateTime->format('H:i');

            if ($reservationTime < $openingHour->format('H:i') || $reservationTime > $closingHour->format('H:i')) {
                $context->buildViolation('Vous ne pouvez réserver pour ' . ucfirst($reservationDay) . ' qu\'entre ' . $openingHour->format('H:i') . ' et ' . $closingHour->format('H:i'))
                    ->addViolation();
            }
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
