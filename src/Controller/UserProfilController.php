<?php

namespace App\Controller;

use App\Form\EditProfilType;
use App\Form\ResetPasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/user/profil", name="user_profil")
     */
    public function index()
    {
        return $this->render('user_space/profil.html.twig');
    }

    /**
     * @Route("/user/profil/update", name="profil_update")
     */
    public function profilUpdate(Request $request){

        $user = $this->getUser();
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            if($form->isValid()){
                $data = $form->getData();
                // echapper les caractères speciaux
                $user->setName(strip_tags($data->getName()));

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
     * @Route("/user/profil/updatePassword", name="profil_update_pass")
     */
    public function profilUpdatePass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // vérifier que les mots de passe sont identique 
            if($request->request->get('first_options') == $request->request->get('second_options')){
                // modifie le mot de passe encodé 
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user, $form->get('password')->getData())
                    );

                $manager = $this->getDoctrine()->getManager();
                $manager->flush();
                $this->addFlash(
                    'success',
                    'Votre mot de passe à bien été modifié');

                    return $this->redirectToRoute('user_profil');
            }
            else{
                $this->addFlash(
                    'danger',
                    'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user_space/resetPassword.html.twig', [
            'formPass' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/profil/delete", name="profil_delete")
     */
    public function profilDelete(){
        
        $user = $this->getUser();
        $this->container->get('security.token_storage')->setToken(null);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        
        return $this->render('user_space/deleteProfil.html.twig');
    }
}
