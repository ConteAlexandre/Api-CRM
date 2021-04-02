<?php

namespace App\Controller;

use App\Form\Account\ProfileFormType;
use App\Manager\UserManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/api", name="api_")
 */
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
     * @Route("/profile", name="profile", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function profile(SerializerInterface $serializer): JsonResponse
    {
        $response = new JsonResponse();
        $slug = $this->getUser()->getSlug();
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
     * @Route("/updateProfile" , name="updateProfile", methods={"PUT"})
     * @param Request $request
     */
    public function updateProfil(Request $request){
            $data = json_decode($request->getContent(), true);
            $user = $this->getUser();
            $form = $this->createForm(ProfileFormType::class, $user);
            $form->submit($data);
            $this->userManager->save($user);
    }

}
