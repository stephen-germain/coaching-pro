<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Services;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar(BookingRepository $bookingRepository): Response
    {
        // Pour afficher tous les utilisateurs de la base de données
        $events = $bookingRepository->findAll();
        
        $rdv = [];

        // Boucle pour mettre dans un tableau les données 
        foreach($events as $event){
            $rdv[]= [
                'start' =>$event->getBeginAt()->format('Y-m-d H:i'),
                'title' => $event->getTitle(),
            ];
        }

        // on encode les données en Json pour les afficher sur le calendrier
        $data = json_encode($rdv);
        return $this->render('booking/calendar.html.twig', compact('data'));
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // créer un objet
        $booking = new Booking();
         // créer le formulaire
        $form = $this->createForm(BookingType::class, $booking);
        // gérer la saisie du formulaire
        $form->handleRequest($request);
          // pour ajouter l'id dans la clé étranger de la table Booking
        $booking->setUsers($this->getUser()); 

        // $data = $this->getBeginAt();
         // Ajouter des données dans la base de données
        if ($form->isSubmitted() && $form->isValid()) {

            // if(!$data){
             // si c'est le formulaire est valide, on récuperer l'entityManager
            $entityManager = $this->getDoctrine()->getManager();
            // pour enregistrer les données
            $entityManager->persist($booking);
            // pour mettre à jour la base de données
            $entityManager->flush();

            return $this->redirectToRoute('booking_calendar');
            // }
        }

        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
             // créer la vue du formulaire
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }
}
