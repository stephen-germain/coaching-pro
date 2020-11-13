<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServiceFormType;
use App\Repository\ServicesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminServiceController extends AbstractController
{
    /**
     * @Route("/admin/service", name="admin_service")
     */
    public function index(ServicesRepository $servicesRepository): Response
    {
        return $this->render('admin/adminServices.html.twig', [
            'services' => $servicesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/service/create", name="create_service")
     */
    public function createService(Request $request)
    {
        $service = new Services();

        $form = $this->createform(ServiceFormType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($service);
                $manager->flush();
                $this->addFlash(
                    'succes',
                    'Le service à bien été rajouté'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Un erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_service'); 
        }
        return $this->render('admin/adminServiceForm.html.twig', [
            'formService' => $form ->createView()
        ]);
    }
    /**
     * @Route("/admin/service/update-{id}", name="service_update")
     */
    public function updateService(ServicesRepository $servicesRepository, Request $request, $id)
    {
        $service = $servicesRepository->find($id);
        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($service);
            $manager->flush();
            $this->addFlash(
                'succes',
                'Le service à bien été modifié'
            );
            
            return $this->redirectToRoute('admin_service');
        }

        return $this->render('admin/adminServiceForm.html.twig', [
            'formService' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/service/delete-{id}", name="service_delete")
     */
    public function deleteService(ServicesRepository $servicesRepository, $id)
    {
        $service = $servicesRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($service);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le service à bien été supprimé'
        );

        return $this->redirectToRoute('admin_service');
    }

}
