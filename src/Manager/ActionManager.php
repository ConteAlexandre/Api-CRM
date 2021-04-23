<?php

namespace App\Manager;

use App\Entity\Action;
use App\Repository\ActionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ActionManager
 */
class ActionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ActionRepository
     */
    private $actionRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ActionManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ActionRepository       $actionRepository
     * @param LoggerInterface        $logger
     */
    public function __construct(EntityManagerInterface $entityManager, ActionRepository $actionRepository, LoggerInterface $logger)
    {
        $this->em = $entityManager;
        $this->actionRepository = $actionRepository;
        $this->logger = $logger;
    }

    /**
     * @return Action
     */
    public function create()
    {
        $action = new Action();

        return $action;
    }

    /**
     * @return Action[]
     */
    public function getAllAction(): array
    {
        return $this->actionRepository->findAll();
    }

    /**
     * @param Action $action
     * @param bool   $andFlush
     */
    public function save(Action $action, $andFlush = true)
    {
        $this->em->persist($action);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}