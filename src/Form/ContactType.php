<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Your name',
                    'class' => 'form-control'],
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'Your email',
                    'class' => 'form-control'],
            ])
            ->add('sujet',TextType::class, [
                'attr' => [
                    'placeholder' => 'Subject',
                    'class' => 'form-control'],
            ])
            ->add('message',TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'form-control'],
            ])
            ->add('captcha', ReCaptchaType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Send',
                'attr' => ['class' => 'button button-a button-big button-rouded']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
