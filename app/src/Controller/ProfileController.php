<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
        if($this->getUser()->getBiography() == null && empty($this->getUser()->getProfilPhotos()[0]))
        {
            return $this->render('profile/register.html.twig');
        }

        return $this->render('profile/index.html.twig');
    }
}
