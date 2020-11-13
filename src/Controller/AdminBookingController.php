<?php

namespace App\Controller;

use App\Repository\BookingRepository;
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
}
