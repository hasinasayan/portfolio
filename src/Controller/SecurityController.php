<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/signup', name: 'signup')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $formRegistration = $this->createForm(RegistrationType::class,$user);

        $formRegistration->handleRequest($request);
        if ($formRegistration->isSubmitted() && $formRegistration->isValid()){
            $hash = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_utile');
        }
        return $this->render('security/registration.html.twig',
        [
            'formRegistration' => $formRegistration->createView()
        ]);

    }
    #[Route('/login', name: 'login')]
    public function login()
    {

        return $this->render('security/login.html.twig');

    }
    #[Route('/logout', name: 'logout')]
    public function logout()
    {
    }
}
