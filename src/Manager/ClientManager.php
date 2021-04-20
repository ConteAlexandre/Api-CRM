<?php


namespace App\Manager;


use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;


    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * ClientManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->em = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @return Client
     */
    public function createClient(): Client
    {
        $client = new Client();
        return $client;
    }


    /**
     * @return Client[]
     */
    public function getAllClient(){
        $client = $this->clientRepository->findAll();
        return $client;
    }


    /**
     * @param $slug
     * @return Client
     */
    public function getClientBySlug($slug)
    {
        $client = $this->clientRepository->findOneBySlug($slug);
        return $client;
    }

    /**
     * @param Client $client
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(Client $client, $andFlush = true)
    {
        $this->em->persist($client);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}