<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index()
    {
        return $this->render('booking/booking.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
}
