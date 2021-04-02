<?php

namespace App\Controller;

use App\Form\Account\PasswordFormType;
use App\Form\Account\ProfileFormType;
use App\Manager\UserManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/updateProfile", name="updateProfile", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateProfil(Request $request, SerializerInterface $serializer, ValidatorInterface $validator){
            $data = json_decode($request->getContent(), true);
            $user = $this->getUser();
            $form = $this->createForm(ProfileFormType::class, $user);
            $form->submit($data);

            $violation = $validator->validate($user);
            if (0 !== count($violation)) {
                foreach ($violation as $error) {
                    return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                }
            }
            $this->userManager->save($user);
            return JsonResponse::fromJsonString($this->serializeUser($user,$serializer));
    }

    /**
     * @Route("/updateUserPassword", name="updateUserPassword", methods={"put"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateUserPassword(Request $request,SerializerInterface $serializer, ValidatorInterface $validator) {
        $data = json_decode($request->getContent(), true);
        $user = $this->getUser();
        $form = $this->createForm(PasswordFormType::class, $user);
        $form->submit($data);
        $violation = $validator->validate($user);
        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $this->userManager->save($user);
        return JsonResponse::fromJsonString($this->serializeUser($user,$serializer));
    }

}
