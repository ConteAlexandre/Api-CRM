<?php


namespace App;


use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ClientController
 *
 * @Route("/api", name="api_")
 */
class ClientController extends AbstractController
{
    private function serializeClient($objet, SerializerInterface $serializer, $groupe="client"): string
    {
        return $serializer->serialize($objet,"json", SerializationContext::create()->setGroups(array($groupe)));
    }
    public function AllClients()
    {

    }
    public function profileClient()
    {

    }
    public function UpdateProfileClient()
    {

    }
}