<?php

namespace App\Controller\Actions;

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
     * @Route("/archived", name="archived")
     *
     * @param               $slug
     * @param ClientManager $clientManager
     *
     * @return Response
     */
    public function archivedAction($slug, ClientManager $clientManager): Response
    {
        $user = $this->getUser();
        $client = $clientManager->getClientBySlug($slug);

        if ($user) {
            $client->setIsArchived(true);

            $this->addFlash('success', sprintf("The client %s has been archived", $client->getFirstName()));
            return $this->redirectToRoute('clients');
        } else {
            return $this->redirectToRoute('homepage');
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

            $this->sendMail($form->get('client')->getData(), $this->getParameter('invoice_directory').'/'.$invoice->getFilename());
        }

        return $this->render('user/create_invoice.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $client
     * @param $invoice
     *
     * @throws TransportExceptionInterface
     */
    private function sendMail($client, $invoice)
    {
        $email = (new Email())
            ->from($this->getUser()->getEmail())
            ->to($client->getEmail())
            ->subject('Invoice')
            ->attachFromPath($invoice)
            ->text('Test send invoice')
        ;

        $this->mailer->send($email);
    }
}