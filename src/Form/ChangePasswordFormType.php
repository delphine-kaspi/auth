<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ],
                'first_options' => [
                    'label' => 'Mot de passe <span>*</span>',
                    'label_html' => true,
                    'attr' => [
                        'placeholder' => 'Saisissez votre mot de passe',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confimation du mot de passe <span>*</span>',
                    'label_html' => true,
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe',
                    ],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[+!%&@.\-_]).{12,}$/',
                        'match' => true,
                        'message' => 'Votre mot de passe doit comporter au moins douze caracteres, au moins une lettre majuscule et une minuscule, un chiffre et un symbole : + ! * $ @ % _ - .'
                    ])
                ],
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => false,
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
