<?php


namespace App\Controller\Actions;


use App\Form\Actions\AppointmentFormType;
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
     * @Route("/createAppointment", name="createAppointment")
     * @param ExchangeManager $exchangeManager
     * @param Request $request
     * @return Response
     */
    public function createAppointment(ExchangeManager $exchangeManager, Request $request) : Response {
        $exchange = $exchangeManager->createExchange();
        $form = $this->createForm(AppointmentFormType::class, $exchange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exchangeManager->save($exchange);


        }

        return $this->render('user/create_exchange.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}