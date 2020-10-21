<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/user/profil", name="user_profil")
     */
    public function index()
    {

        
        return $this->render('user_space/profil.html.twig', [
            'controller_name' => 'UserProfilController',
        ]);
    }

    /**
     * @Route("/profil/update", name="profil_update")
     */
    public function profilUpdate(Request $request){

        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Le profil à été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user_space/editProfil.html.twig', [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil/delete", name="profil_delete")
     */
    public function profilDelete(){
        // $user = $this->getUser();

        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

        // $manager = $this->getDoctrine()->getManager();
        // $manager->remove($user);
        // $manager->flush();

        // $this->addFlash(
        //     'danger',
        //     'Le profil à bien été supprimée'
        // );

        // return $this->render('user_space/deleteProfil.html.twig');

        $user = $this->getUser();
$this->container->get('security.token_storage')->setToken(null);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();

// Ceci ne fonctionne pas avec la création d'une nouvelle session !
$this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !'); 

return $this->render('user_space/deleteProfil.html.twig');
    }
}
