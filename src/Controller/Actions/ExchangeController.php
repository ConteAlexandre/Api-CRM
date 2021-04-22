<?php

namespace App\Controller\Actions;

use App\Form\Actions\AppointmentFormType;
use App\Manager\ActionManager;
use App\Manager\ExchangeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ExchangeController extends AbstractController
{
    /**
     * @var ExchangeManager $exchangeManager
     */
    protected $exchangeManager;

    public function __construct(ExchangeManager $exchangeManager)
    {
        $this->exchangeManager = $exchangeManager;
    }

    /**
     * @Route("/create/appointment", name="createAppointment")
     * @param ExchangeManager $exchangeManager
     * @param Request         $request
     * @param ActionManager   $actionManager
     *
     * @return Response
     */
    public function createAppointment(ExchangeManager $exchangeManager, Request $request, ActionManager $actionManager) : Response {
        $action = $actionManager->create();
        $exchange = $exchangeManager->createExchange();
        $form = $this->createForm(AppointmentFormType::class, $exchange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->get('type')->getData());
            $action
                ->setTitle(sprintf("Create Appointment of type : %s", $form->get('type')->getData()[0]))
                ->setExchange($exchange)
                ->setClient($form->get('client')->getData());
            $exchangeManager->save($exchange);
            $actionManager->save($action);

            $this->addFlash('success', 'The exchange has been created');
            return $this->redirectToRoute('clients');
        }

        return $this->render('user/create_exchange.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}