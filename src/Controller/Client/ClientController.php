<?php

namespace App\Controller\Client;

use App\Form\Account\RegisterClientFormType;
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
     * ClientController constructor.
     * @param ClientManager $clientManager
     */
    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
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
        $client = $this->clientManager->getClientBySlug($slug);
        $form = $this->createForm(RegisterClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function createClient(Request $request) : Response
    {
        $client = $this->clientManager->createClient();
        $form = $this->createForm(RegisterClientFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->clientManager->save($client);

            $this->addFlash('success', sprintf("The client has been created : %s", $client->getFirstName()));
            return $this->redirectToRoute('clients');
        }

        return $this->render('client/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}