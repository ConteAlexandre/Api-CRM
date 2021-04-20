<?php


namespace App\Controller\Client;


use App\Form\Account\RegisterClientFormType;
use App\Manager\ClientManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ClientController
 *
 * @Route("/api", name="api_")
 */
class ClientController extends AbstractController
{


    /**
     * @var ClientManager $clientManager
     */
    protected $clientManager;

    /**
     * ClientController constructor.
     * @param ClientManager $clientManager
     */
    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @param $objet
     * @param SerializerInterface $serializer
     * @param string $groupe
     * @return string
     */
    private function serializeClient($objet, SerializerInterface $serializer, $groupe="client"): string
    {
        return $serializer->serialize($objet,"json", SerializationContext::create()->setGroups(array($groupe)));
    }


    /**
     * @Route("/clients", name="clients", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function AllClients(SerializerInterface $serializer) : JsonResponse
    {
        $response = new JsonResponse();

        $client = $this->clientManager->getAllClient();
        $jsonContent = $this-> serializeClient($client, $serializer);
        $response->setContent($jsonContent);
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }


    /**
     * @Route("/profileClient/{slug}", name="profileClient", methods={"GET"})
     * @param SerializerInterface $serializer
     * @param $slug
     * @return JsonResponse
     */
    public function profileClient(SerializerInterface $serializer, $slug): JsonResponse
    {
        $response = new JsonResponse();

        $client = $this->clientManager->getClientBySlug($slug);
        $jsonContent = $this->serializeClient($client,$serializer);
        $response->setContent($jsonContent);
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }


    /**
     * @Route("/updateProfileClient/{slug}", name="UpdateProfileClient", methods={"PUT"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateProfileClient(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, $slug) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $client = $this->clientManager->getClientBySlug($slug);
        $form = $this->createForm(RegisterClientFormType::class, $client);
        $form->submit($data);

        $violation = $validator->validate($client);
        if (0 !== count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }
        $this->clientManager->save($client);
        return JsonResponse::fromJsonString($this->serializeClient($client,$serializer));
    }
}