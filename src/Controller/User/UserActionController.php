<?php

namespace App\Controller\User;

use App\Manager\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class UserActionController
 */
class UserActionController extends AbstractController
{
    /**
     * @param               $slug
     * @param ClientManager $clientManager
     *
     * @return RedirectResponse
     */
    public function archivedAction($slug, ClientManager $clientManager)
    {
        $user = $this->getUser();
        $client = $clientManager->getClientBySlug($slug);

        if ($user) {
            $client->setIsArchived(true);

            $this->addFlash('success', 'The client is archived');

            return $this->redirectToRoute('api_clients');
        } else {
            throw new AccessDeniedException('Not Authorized');
        }
    }
}