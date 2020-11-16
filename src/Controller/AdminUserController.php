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
            'users' => $user = $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/user/update-{id}", name="admin_user_update")
     */
    public function userUpdate(UserRepository $userRepository, Request $request, $id)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(AdminUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le profil à bien été modifié'
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
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\utilisateur à bien été supprimé'
        );

        return $this->redirectToRoute('admin_user');
    }
}
