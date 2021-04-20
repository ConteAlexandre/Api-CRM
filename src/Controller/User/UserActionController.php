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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserActionController
 *
 * @Route("/api", name="user_action_")
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
     * @Route("/upload/invoice", name="upload_invoice", methods={"GET", "POST"})
     *
     * @param InvoiceManager     $invoiceManager
     * @param Request            $request
     * @param ValidatorInterface $validator
     * @param InvoiceUploader    $invoiceUploader
     *
     * @return JsonResponse
     * @throws TransportExceptionInterface
     */
    public function uploadInvoiceAction(InvoiceManager $invoiceManager, Request $request, ValidatorInterface $validator, InvoiceUploader $invoiceUploader): JsonResponse
    {
        $data = json_encode($request->getContent(), true);
        $invoice = $invoiceManager->createInvoice();
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);
        $form->submit($data);

        $violation = $validator->validate($invoice);
        if (0 != count($violation)) {
            foreach ($violation as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $invoiceFile = $data['filename'];
        if ($invoiceFile) {
            $invoiceFilename = $invoiceUploader->upload($invoiceFile);
            $invoice->setFilename($invoiceFilename);
        }

        $invoiceManager->save($invoice);

        $this->sendMail($data['client']->getEmail());

        return new JsonResponse('The invoice has been upload!');
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
            ->to($client)
            ->subject('Invoice')
            ->text('Test send invoice')
        ;

        $this->mailer->send($email);
    }
}