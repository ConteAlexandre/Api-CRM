<?php


namespace App\Controller;


use App\Manager\ClientManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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


    public function profileClient()
    {

    }


    public function UpdateProfileClient()
    {

    }
}