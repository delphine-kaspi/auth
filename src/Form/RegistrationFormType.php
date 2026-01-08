<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email <span>*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir un email'
                ],
                'constraints' => [
                    new Email([
                        'message' => 'Veuillez saisir un email valide'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez saisir un email'
                    ])
                ]
            ])

            ->add('prenom',null, [
                'label' => 'Prénom <span>*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir un prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prénom'
                    ])
                ]
            ])

            ->add('nom', null, [
                'label' => 'Nom <span>*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisir un nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom'
                    ])
                ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les conditions d\'utilisations <span>*</span>',
                'label_html' => true,
                'required' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions générales d\'utilisation du site',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe <span>*</span>',
                'label_html' => true,
                'required' => false,
                'attr' => ['autocomplete' => 'new-password',
                    'placeholder' => 'Saisir un mot de passe'
            ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Mot de passe incorrect',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
