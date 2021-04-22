<?php

namespace App\Controller\Client;

use App\Form\Account\RegisterClientFormType;
use App\Manager\ActionManager;
use App\Manager\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 *
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @var ClientManager $clientManager
     */
    protected $clientManager;

    /**
     * @var ActionManager $actionManager
     */
    protected $actionManager;

    /**
     * ClientController constructor.
     *
     * @param ClientManager $clientManager
     * @param ActionManager $actionManager
     */
    public function __construct(ClientManager $clientManager, ActionManager $actionManager)
    {
        $this->clientManager = $clientManager;
        $this->actionManager = $actionManager;
    }

    /**
     * @Route("/list", name="clients")
     *
     * @return Response
     */
    public function listClients() : Response
    {
        $user = $this->getUser();
        $clients = $this->clientManager->getClientByUser($user);

        return $this->render('client/list.html.twig', [
            'user' => $user,
            'clients' => $clients,
        ]);
    }


    /**
     * @Route("/profile/{slug}", name="profileClient")
     * @param $slug
     *
     * @return Response
     */
    public function profileClient($slug): Response
    {
        $client = $this->clientManager->getClientBySlug($slug);

        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }


    /**
     * @Route("/update/{slug}", name="update_client")
     * @param Request $request
     * @param         $slug
     *
     * @return Response
     * @throws \Exception
     */
    public function updateProfileClient(Request $request, $slug) : Response
    {
        $action = $this->actionManager->create();
        $client = $this->clientManager->getClientBySlug($slug);
        $form = $this->createForm(RegisterClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $action->setTitle('Update Client')
                ->setClient($client);
            $this->actionManager->save($action);
            $this->clientManager->save($client);

            $this->addFlash('success', sprintf("The profile %s has been updated", $client->getFirstName()));
            return $this->redirectToRoute('clients');
        }

        return $this->render('client/profile.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    /**
     * @Route("/create", name="createClient")
     *
     * @param Request       $request
     *
     * @return Response
     * @throws \Exception
     */
    public function createClient(Request $request) : Response
    {
        $client = $this->clientManager->createClient();
        $action = $this->actionManager->create();
        $form = $this->createForm(RegisterClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $action->setTitle('Create Client')
                    ->setClient($client);
            $this->actionManager->save($action);
            $this->clientManager->save($client);

            $this->addFlash('success', sprintf("The client has been created : %s", $client->getFirstName()));
            return $this->redirectToRoute('clients');
        }

        return $this->render('client/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}