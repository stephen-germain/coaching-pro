<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(ServicesRepository $servicesRepository)
    {
        $services = $servicesRepository->findAll();

        return $this->render('booking/booking.html.twig', [
            'services' => $services,
        ]);
           
    
    }
}
