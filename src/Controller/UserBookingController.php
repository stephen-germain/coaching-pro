<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBookingController extends AbstractController
{
    /**
     * @Route("/user/booking/mes-reservations", name="user_booking")
     */
    public function index(): Response
    {
        return $this->render('user_space/user_booking.html.twig');
    }

    /**
     * @Route("/user/booking/new_booking", name="user_booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
         // créer un objet
        $booking = new Booking();
        // création le formulaire à partir de BookingType
        $form = $this->createForm(BookingType::class, $booking);

        // gérer la saisie du formulaire
        $form->handleRequest($request);
          // pour ajouter l'id dans la clé étranger de la table Booking
        $booking->setUsers($this->getUser()); 

        // Ajouter des données dans la base de données
        if ($form->isSubmitted() && $form->isValid()) {
             // si c'est le formulaire est valide, on récuperer l'entityManager
            $entityManager = $this->getDoctrine()->getManager();
              // pour enregistrer les données
            $entityManager->persist($booking);
              // pour mettre à jour la base de données
            $entityManager->flush();

            return $this->redirectToRoute('user_booking');
        }

        return $this->render('user_space/newBooking.html.twig', [
            'booking' => $booking,
            // créer la vue du formulaire
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user/booking/edit-{id}", name="user_booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BookingRepository $bookings, $id): Response
    {
        $booking = $bookings->find($id);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($booking);
            $manager->flush();

            $this->addFlash(
                'success',
                'La réservation a bien été modfiée'
            );

            return $this->redirectToRoute('user_booking');
        }

        return $this->render('user_space/editBooking.html.twig', [
            // 'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/booking/delete-{id}", name="user_booking_delete")
     */
    public function delete(Request $request, BookingRepository $booking, $id): Response
    {
        $booking = $booking->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            'La réservation a bien été supprimée'
        );

        return $this->redirectToRoute('user_booking');
    }
}
