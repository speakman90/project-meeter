<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Activities;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(): Response
    {
    
        if($this->getUser() !== null)
        {
            if($this->getUser()->getBiography() == null && empty($this->getUser()->getProfilPhotos()[0]))
            {
                return $this->render('profile/register.html.twig');
            }
            
        }
        else
        {
            return $this->redirectToRoute('app_home');
        }

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

    #[Route('/api/v1/getActivities', name: 'api_activities', methods: 'GET')]
    public function getActivites(EntityManagerInterface $entityManager)
    {
        $activities = $entityManager->getRepository(Activities::class)->findAll();
        
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        
        // Serialize your object in Json
        $jsonObject = $serializer->serialize($activities, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object;
            }
        ]);
        
        // For instance, return a Response with encoded Json
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/api/v1/addActivities', name: 'api_activities_add', methods: 'POST')]
    public function addActivites(Request $request, EntityManagerInterface $entityManager)
    {
        $id = $this->getUser()->getId();
        $user = $entityManager->getRepository(Users::class)->find($id);
        $response = new Response;
        $datas = $request->request;

        if($datas == null)
        {
            return $response->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
        }
        else
        {
            $activities = $entityManager->getRepository(Activities::class)->find($datas->get('id'));
            
            $user->addActivity($activities);

            $entityManager->flush();

            return $response->setStatusCode(Response::HTTP_OK);
        }

        return $response->setStatusCode(Response::HTTP_OK);

    }
}
