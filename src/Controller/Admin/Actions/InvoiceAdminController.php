<?php

namespace App\Controller\Admin\Actions;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class InvoiceAdminController
 */
class InvoiceAdminController extends CRUDController
{
    public function sendAction($id): Response
    {
        $object = $this->admin->getSubject();

        if (!$object) {
            throw new NotFoundHttpException(sprintf("unable to find the object with id : %s", $id));
        }


    }
}