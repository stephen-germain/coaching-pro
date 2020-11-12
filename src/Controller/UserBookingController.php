<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBookingController extends AbstractController
{
    /**
     * @Route("/user/booking", name="user_booking")
     */
    public function index(Booking $booking): Response
    {
        return $this->render('user_space/user_booking.html.twig', [
            'booking' => $booking,
        ]);
    }
}
