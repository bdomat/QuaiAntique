<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

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
                    '1 convive' => 1,
                    '2 convives' => 2,
                    '3 convives' => 3,
                    '4 convives' => 4,
                    '5 convives' => 5,
                    '6 convives' => 6,
                    '7 convives' => 7,
                    '8 convives' => 8,
                    '9 convives' => 9,
                    '10 convives' => 10,
                    '11 convives' => 11,
                    '12 convives' => 12,
                    '13 convives' => 13,
                    '14 convives' => 14,
                    '15 convives' => 15,
                    '16 convives' => 16,
                    '17 convives' => 17,
                    '18 convives' => 18,
                    '19 convives' => 19,
                    '20 convives' => 20,
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
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'type' => PasswordType::class,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control',
                    'options' => [
                        'attr' => [
                            'type' => 'password'
                        ]
                    ]
                ],
                'first_options' => ['label' => 'Mot de passe :'],
                'second_options' => ['label' => 'Confirmer le mot de passe :'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new NotCompromisedPassword(),
                    new Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Votre mot de passe doit contenir au moins une majuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[0-9]/',
                        'message' => 'Votre mot de passe doit contenir au moins un chiffre.',
                    ]),
                    new Regex([
                        'pattern' => '/[^a-zA-Z0-9]/',
                        'message' => 'Votre mot de passe doit contenir au moins un caractère spécial.',
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
