<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            // Envoyer le mail
            $message = (new \Swift_Message('Nouveau Contact'))
                // L'expéditeur
                ->setFrom($contact['email'])

                // Le déstinataire
                ->setTo('stephen.germain@free.fr')

                // Message avec la vue Twig
                ->setBody(
                    $this->renderView(
                        'email/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;

            // Envoye le message
            $mailer->send($message);

            $this->addFlash(
                'message',
                'Le message a bien été envoyé'
            );
            return $this->redirectToRoute('home');
            
        }
        return $this->render('home/home.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu()
    {
        return $this->render('home/cgu.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentions()
    {
        return $this->render('home/mentionsLegales.html.twig');
    }

    /**
     * @Route("/politique-de-confidentialité", name="politique-confidentialite")
     */
    public function politique()
    {
        return $this->render('home/politiqueConfidentialite.html.twig');
    }
}
