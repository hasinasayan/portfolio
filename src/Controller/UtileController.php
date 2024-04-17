<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class UtileController extends AbstractController
{
    #[Route('/', name: 'app_utile')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $client = new Client();
        $form = $this->createForm(ContactType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();

            $mailContent = (new Email())
                ->from($form->get('email')->getData())
                ->to('admin@mail.com')
                ->subject($form->get('sujet')->getData())
                ->text($form->get('message')->getData());
            $mailer->send($mailContent);

            return $this->redirect($request->getUri().'?status=1');
        }

        return $this->render('base.html.twig',
            [
                'contactform' => $form,
            ]);
    }
}
