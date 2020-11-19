<?php

namespace App\Controller;

use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/all_booking", name="admin_booking", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/adminBooking.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

     /**
     * @Route("/admin/booking/new", name="admin_booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        
        $form->handleRequest($request);
        $booking->setUsers($this->getUser()); 

        // $data = getBeginAt();
        if ($form->isSubmitted() && $form->isValid()) {

            // if(!$data){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('admin_booking');
            
           
        }

        return $this->render('admin/AdminBookingForm.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/booking/update-{id}", name="admin_booking_update")
     */
    public function updateService(BookingRepository $bookingRepository, Request $request, $id)
    {
        $booking = $bookingRepository->find($id);
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($booking);
            $manager->flush();
            $this->addFlash(
                'succes',
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
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            'success',
            'La réservation a bien été supprimée'
        );

        return $this->redirectToRoute('admin_booking');
    }
}
