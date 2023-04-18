<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
//        if($this->getUser()->getBiography() == null && empty($this->getUser()->getProfilPhotos()[0]))
//        {
//            return $this->render('profile/register.html.twig');
//        }
//        dd($this->getUser());
        return $this->render('profile/index.html.twig');
    }

    #[Route('/profil/addPhoto', name: 'add_photo', methods: 'POST')]
    public function addPhoto(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $photo = $request->files->get('photo');
        if (!$photo) {
            return $this->redirectToRoute('app_profile');
        }

        if ($photo) {
            $newFilename = md5(uniqid()).'.'.$photo->guessExtension();
        }
        try {
            $userDir = $this->getParameter("photos_directory"). '/' . $user->getUsername() . $user->getId();

            $photo->move($userDir, $newFilename);

            $userPhotos = $user->getProfilPhotos();
            $userPhotos[] = $newFilename;

            $user->setProfilPhotos($userPhotos);

            $entityManager->persist($user);
            $entityManager->flush();

        } catch (FileException $e) {
            throw new FileException($e);
        }

        return $this->redirectToRoute('app_profile');
    }

    #[Route('/profil/deletePhoto', name: 'delete_photo', methods: 'POST')]
    public function removePhoto(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $photoName = $request->request->get('deletePhoto');
        $userDir = $this->getParameter("photos_directory") . '/' . $user->getUsername() . $user->getId();
        $photoPath = $userDir . '/' . $photoName;

        if (file_exists($photoPath)) {
            unlink($photoPath);
        }
        $userPhotos = $user->getProfilPhotos();
        $key = array_search($photoName, $userPhotos);
        if ($key !== false) {
            unset($userPhotos[$key]);
        }
        $user->setProfilPhotos($userPhotos);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_profile');
    }

    #[Route('/profil/addMessage', name: 'add_message', methods: 'POST')]
    public function addMessage(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $textMessage = $request->request->get('message');

        $user->setBiography($textMessage);

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_profile');
    }
    #[Route('/profil/addJob', name: 'add_job', methods: 'POST')]
    public function addJob(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $textMessage = $request->request->get('job');
        $user->setJob($textMessage);

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_profile');
    }
    #[Route('/profil/addCity', name: 'add_city', methods: 'POST')]
    public function addCity(Request $request, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException();
        }

        $textMessage = $request->request->get('city');

        $user->setCity($textMessage);

        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_profile');
    }
}
