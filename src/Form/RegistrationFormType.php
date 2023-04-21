<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('allergies', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('default_guests_number', ChoiceType::class, [
                'choices' => [
                    '1 invité' => 1,
                    '2 invités' => 2,
                    '3 invités' => 3,
                    '4 invités' => 4,
                    '5 invités' => 5,
                    '6 invités' => 6,
                    '7 invités' => 7,
                    '8 invités' => 8,
                    '9 invités' => 9,
                    '10 invités' => 10,
                    '11 invités' => 11,
                    '12 invités' => 12,
                    '13 invités' => 13,
                    '14 invités' => 14,
                    '15 invités' => 15,
                    '16 invités' => 16,
                    '17 invités' => 17,
                    '18 invités' => 18,
                    '19 invités' => 19,
                    '20 invités' => 20,
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('RGPDconsent', CheckboxType::class, [
                'label' => 'En m\'inscrivant sur ce site, j\'accepte que mes données soient stockées et utilisées pour faciliter le traitement de mes réservations',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez acceptez accepter que vos données soient stockées dans notre base de données.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}