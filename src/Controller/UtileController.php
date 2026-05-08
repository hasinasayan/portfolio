<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class UtileController extends AbstractController
{
    #[Route('/', name: 'app_utile',methods: "POST|GET")]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, LoggerInterface $logger): Response
    {
        $client = new Client();
        $form = $this->createForm(ContactType::class, $client);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $request->isXmlHttpRequest())
        {
            $data = $request->request->all()['contact'];
            if(empty($request->request->get('g-recaptcha-response') )){
                return $this->json([
                    'success' => false,
                    'message' => 'The captcha is invalid. Please try again.'
                ]);
            }else {
                $client->setEmail($data['email']);
                $client->setNom($data['nom']);
                $client->setSujet($data['sujet']);
                $client->setMessage($data['message']);
                $client->setDate(new \DateTime('now', new \DateTimeZone('Europe/Moscow')));

                $entityManager->persist($client);
                $entityManager->flush();
                try {
                    $mailContent = (new Email())
                        ->from($data['email'])
                        ->to('admin@mail.com')
                        ->subject($data['sujet'])
                        ->text($data['message']);
                    $mailer->send($mailContent);
                    return $this->json([
                        'success' => true,
                        'message' => 'Votre message a été envoyé avec succès !'
                    ]);
                } catch (\Exception $e) {
                    $logger->error('Erreur envoi email: ' . $e->getMessage());
                    return $this->json([
                        'success' => false,
                        'message' => 'Erreur lors de l\'envoi du message. Veuillez réessayer.'
                    ]);
                }
            }

        }
        return $this->render('base.html.twig',
            [
                'contactform' => $form,
            ]);
    }
}
