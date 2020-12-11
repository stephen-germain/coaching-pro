<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking/all_booking", name="admin_booking", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/adminBooking.html.twig', [
            // Pour afficher tous les rendez-vous de la base de données
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/booking/new", name="admin_booking_new", methods={"GET","POST"})
     */
    public function new(Request $request, Booking $booking): Response
    {
        // créer un objet
        $booking = new Booking();

        // créer le formulaire
        $form = $this->createForm(BookingType::class, $booking);
        
        // gérer la saisie du formulaire
        $form->handleRequest($request);

        // pour ajouter l'id dans la clé étranger de la table Booking
        $booking->setUsers($this->getUser()); 

        // Ajouter des données dans la base de données
        if ($form->isSubmitted() && $form->isValid()) {

            // pour récuperer l'entityManager
            $entityManager = $this->getDoctrine()->getManager();

            // pour enregistrer les données
            $entityManager->persist($booking);

            // pour mettre à jour la base de données
            $entityManager->flush();

            return $this->redirectToRoute('admin_booking');
        }

        return $this->render('admin/AdminBookingForm.html.twig', [
            'booking' => $booking,

            // créer la vue du formulaire
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/booking/update-{id}", name="admin_booking_update")
     */
    public function updateService(BookingRepository $bookingRepository, Request $request, $id)
    {
        // trouver un rendez-vous par id
        $booking = $bookingRepository->find($id);
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($booking);
            $manager->flush();
            $this->addFlash(
                'success',
                'La réservation à bien été modifiée'
            );
            
            return $this->redirectToRoute('admin_booking');
        }

        return $this->render('admin/AdminBookingForm.html.twig', [
            'formBooking' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/booking/delete-{id}", name="admin_booking_delete")
     */
    public function deleteBooking(BookingRepository $booking, $id): Response
    {
        $booking = $booking->find($id);

        $manager = $this->getDoctrine()->getManager();

        // pour supprimer une donnée
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            'La réservation a bien été supprimée'
        );

        return $this->redirectToRoute('admin_booking');
    }
}
