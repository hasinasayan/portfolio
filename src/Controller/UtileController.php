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
        if ($request->isXmlHttpRequest() )
        {
            $data = $request->request->all()['contact'];

            $client->setEmail($data['email']);
            $client->setNom($data['nom']);
            $client->setSujet($data['sujet'] );
            $client->setMessage( $data['message']);
            $client->setDate(new \DateTime('now',new \DateTimeZone('Europe/Moscow')));

            $entityManager->persist($client);
            $entityManager->flush();
            try {
                $mailContent = (new Email())
                    ->from($data['email'])
                    ->to('admin@mail.com')
                    ->subject($data['sujet'])
                    ->text($data['message']);
                $mailer->send($mailContent);
            }catch (\Exception $e){
                $form->addError( new FormError($e->getMessage()));
                $logger->error('error form:'. $form->getErrors() );
            }
            if (count($form->getErrors(true)) == 0)
            {
                return $this->json([
                    'success' => true,
                    'message' => 'Your message has been sent. Thank you!'
                ]);
            }else
            {
                return $this->json([
                    'success' => false,
                    'message' => 'Your message can\'t be send, please try again!'
                ]);

            }

        }
        return $this->render('base.html.twig',
            [
                'contactform' => $form,
            ]);
    }
}
