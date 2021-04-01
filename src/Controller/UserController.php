<?php

namespace App\Controller;

use App\Manager\UserManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    /**
     * @var UserManager $userManager
     */
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @Route("/{slug}/profile", name="profile")
     * @param $slug
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function profile($slug, SerializerInterface $serializer): JsonResponse
    {
        $response = new JsonResponse();
        dump($slug);
        $user = $this->userManager->getUserBySlug($slug);
        $jsonContent = $this->serializeUser($user,$serializer);
        $response->setContent($jsonContent);
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }

    /**
     * @Route("/updateProfile" , name="updateProfile")
     */
    public function updateProfil(){

    }

}
