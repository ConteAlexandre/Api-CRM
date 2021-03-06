<?php


namespace App\Manager;


use App\Entity\Exchange;
use App\Repository\ExchangeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ExchangeManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ExchangeRepository
     */
    private $exchangeRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExchangeManager constructor.
     *
     * @param ExchangeRepository     $exchangeRepository
     * @param LoggerInterface        $logger
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ExchangeRepository $exchangeRepository, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->exchangeRepository = $exchangeRepository;
        $this->logger = $logger;
    }

    /**
     * @return Exchange
     */
    public function createExchange(): Exchange
    {
        $exchange = new Exchange();
        $exchange->setEnabled(true);

        return $exchange;
    }

    /**
     * @return Exchange[]
     */
    public function getAllExchange(): array
    {
        return $this->exchangeRepository->findAll();
    }

    /**
     * @param Exchange $Exchange
     * @param bool    $andFlush
     */
    public function save(Exchange $Exchange, $andFlush = true)
    {
        $this->em->persist($Exchange);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}