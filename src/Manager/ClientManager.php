<?php

namespace App\Manager;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Psr\Log\LoggerInterface;

/**
 * Class ClientManager
 */
class ClientManager
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ClientManager constructor.
     *
     * @param ClientRepository $clientRepository
     * @param LoggerInterface  $logger
     */
    public function __construct(ClientRepository $clientRepository, LoggerInterface $logger)
    {
        $this->clientRepository = $clientRepository;
        $this->logger = $logger;
    }

    /**
     * @param $slug
     *
     * @return Client
     */
    public function getClientBySlug($slug)
    {
        return $this->clientRepository->findOneBySlug($slug);
    }
}