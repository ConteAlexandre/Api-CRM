<?php

namespace App\Controller;

use App\Manager\UserManager;
use JMS\Serializer\SerializationContext;
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
        $user = $this->userManager->getUserBySlug($slug);
            $jsonContent = $this->serializeUser($user,$serializer);
            $response->setContent($jsonContent);
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
}
    private function serializeUser($objet, SerializerInterface $serializer, $groupe="user"): string
    {
        return $serializer->serialize($objet,"json", SerializationContext::create()->setGroups(array($groupe)));
    }
/**
     * @Route("/updateProfile" , name="updateProfile")
     */
    public function updateProfil(){

    }

}