<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/signup', name: 'security_signup')]
    public function registration()
    {
        $user = new User();
        $formRegistration = $this->createForm(RegistrationType::class,$user);

        return $this->render('security/registration.html.twig',
        [
            'formRegistration' => $formRegistration->createView()
        ]);

    }
}
