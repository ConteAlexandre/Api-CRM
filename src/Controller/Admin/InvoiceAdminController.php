<?php

namespace App\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Class InvoiceAdminController
 */
class InvoiceAdminController extends CRUDController
{
    public function sendAction($id, MailerInterface $mailer): Response
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf("unable to find the object with id : %s", $id));
        }

        $email = (new Email())
            ->from('test@example.com')
            ->to('michel@example.com')
            ->subject('Test')
            ->text(sprintf("Send id %s", $object->getId()))
        ;

        $mailer->send($email);

        $this->addFlash('sonata_flash_success', 'Cloned successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}