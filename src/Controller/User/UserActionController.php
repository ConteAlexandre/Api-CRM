<?php

namespace App\Controller\User;

use App\Form\InvoiceFormType;
use App\Manager\ClientManager;
use App\Manager\InvoiceManager;
use App\Service\InvoiceUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserActionController
 */
class UserActionController extends AbstractController
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * UserActionController constructor.
     *
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/archived", name="archived", methods={"POST"})
     *
     * @param               $slug
     * @param ClientManager $clientManager
     *
     * @return JsonResponse
     */
    public function archivedAction($slug, ClientManager $clientManager): JsonResponse
    {
        $user = $this->getUser();
        $client = $clientManager->getClientBySlug($slug);

        if ($user) {
            $client->setIsArchived(true);

            return new JsonResponse('The client is archived');
        } else {
            throw new AccessDeniedException('Not Authorized');
        }
    }

    /**
     * @Route("/upload/invoice", name="upload_invoice")
     *
     * @param InvoiceManager     $invoiceManager
     * @param Request            $request
     * @param InvoiceUploader    $invoiceUploader
     *
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function uploadInvoiceAction(InvoiceManager $invoiceManager, Request $request, InvoiceUploader $invoiceUploader): Response
    {
        $user = $this->getUser();
        $invoice = $invoiceManager->createInvoice();
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoiceFile = $form->get('filename')->getData();
            if ($invoiceFile) {
                $invoiceFilename = $invoiceUploader->upload($invoiceFile);
                $invoice->setFilename($invoiceFilename);
            }
            $invoiceManager->save($invoice);

            $this->sendMail($form->get('client')->getData());
        }

        return $this->render('user/create_invoice.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $client
     *
     * @throws TransportExceptionInterface
     */
    private function sendMail($client)
    {
        $email = (new Email())
            ->from($this->getUser()->getEmail())
            ->to($client->getEmail())
            ->subject('Invoice')
            ->text('Test send invoice')
        ;

        $this->mailer->send($email);
    }
}