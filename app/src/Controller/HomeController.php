<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {

        if($request->get('email') || $request->get('password'))
        {
            $this->forward('App\Controller\SecurityController::login', [
                'last_username'=> $request->get('email'),
                'password'=> $request->get('password')
                ]);
        }

        return $this->render('home/index.html.twig');
    }
}
