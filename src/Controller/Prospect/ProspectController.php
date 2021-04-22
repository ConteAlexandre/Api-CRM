<?php

namespace App\Controller\Prospect;

use App\Manager\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProspectController
 *
 * @Route("/prospect", name="prospect_")
 */
class ProspectController extends AbstractController
{
    /**
     * @var ClientManager
     */
    private $clientManager;

    /**
     * ProspectController constructor.
     *
     * @param ClientManager $clientManager
     */
    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @Route("/list", name="list")
     *
     * @return Response
     */
    public function listAction()
    {
        $user = $this->getUser();
        $prospects = $this->clientManager->getClientISProspect($user);

        return $this->render('prospect/list.html.twig', [
            'prospects' => $prospects,
        ]);
    }
}