<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'Your email',
                    'class' => 'form-control'],
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Your username',
                    'class' => 'form-control'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Your password',
                    'class' => 'form-control',
                ]
            ])
            ->add('confirmPassword',PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Your password',
                    'class' => 'form-control',
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Send',
                'attr' => ['class' => 'button button-a button-big button-rouded']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
