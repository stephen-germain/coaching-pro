<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserSpaceController extends AbstractController
{
    /**
     * @Route("/user/space", name="user_space")
     */
    public function index()
    {
        return $this->render('user_space/userspace.html.twig');
    }
}
