<?php

namespace App\Controller;

use App\Form\AdminUserFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('admin/adminUser.html.twig', [
            // Pour afficher tous les utilisateurs de la base de données
            'users' => $user = $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/user/update-{id}", name="admin_user_update")
     */
    public function userUpdate(UserRepository $userRepository, Request $request, $id)
    {
        // trouver un rendez-vous par id
        $user = $userRepository->find($id);

        //créer le formulaire
        $form = $this->createForm(AdminUserFormType::class, $user);
        // gérer la saisie du formulaire
        $form->handleRequest($request);

        // Ajouter des données dans la base de données
        if($form->isSubmitted() && $form->isValid()){
            // pour récuperer l'entityManager
            $manager = $this->getDoctrine()->getManager();
            // pour enregistrer les données
            $manager->persist($user);
            // pour mettre à jour la base de données
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'utilisateur à bien été modifié'
            );

        return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/adminUserForm.html.twig',[
            'formUser' => $form->createView()
        ]);
    } 

    /**
     * @Route("/admin/user/delete-{id}", name="admin_user_delete")
     */
    public function userDelete(UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
         // pour supprimer une donnée
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\utilisateur à bien été supprimé'
        );

        return $this->redirectToRoute('admin_user');
    }
}
