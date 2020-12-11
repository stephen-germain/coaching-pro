<?php

namespace App\Controller;

use App\Repository\ServicesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReserveController extends AbstractController
{
    /**
     * @Route("/reserve", name="reserve")
     */
    public function index(ServicesRepository $servicesRepository)
    {
        // Pour afficher tous les services de la base de données
        $services = $servicesRepository->findAll();

        return $this->render('reserve/reserve.html.twig', [
            'services' => $services,
        ]);     
    }
}
