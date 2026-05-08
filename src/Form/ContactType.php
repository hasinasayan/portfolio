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
                    'placeholder' => 'Nom complet',
                    'class' => 'w-full bg-white/5 border border-white/10 rounded-lg p-4 text-white focus:border-sky-500 focus:ring-0 transition-all outline-none'],
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'w-full bg-white/5 border border-white/10 rounded-lg p-4 text-white focus:border-sky-500 focus:ring-0 transition-all outline-none'],
            ])
            ->add('sujet',TextType::class, [
                'attr' => [
                    'placeholder' => 'Objet',
                    'class' => 'w-full bg-white/5 border border-white/10 rounded-lg p-4 text-white focus:border-sky-500 focus:ring-0 transition-all outline-none'],
            ])
            ->add('message',TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'w-full bg-white/5 border border-white/10 rounded-lg p-4 text-white focus:border-sky-500 focus:ring-0 transition-all outline-none'],
            ])
            ->add('captcha', ReCaptchaType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'w-full py-4 bg-primary-container text-white font-label-md text-label-md rounded-lg glow-border uppercase tracking-widest hover:bg-sky-600 transition-all']
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
