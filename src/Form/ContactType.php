<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom <span>*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Saisir un nom'
                ],
        ])
            ->add('email', EmailType::class, [
                'label' => 'Email <span>*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Saisir un email'
                ],
        ])
            ->add('message', TextareaType::class, [
                'label' => 'Message <span>*</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => 'Saisir un message'
                ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
