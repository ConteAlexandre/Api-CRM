<?php

namespace App\Controller\Admin\Security;

use App\Form\Admin\AdminLoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminLoginController
 * 
 * @Route("/admin", name="admin_")
 */
class AdminLoginController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * AdminLoginController constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="login")
     *
     * @return Response
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(AdminLoginFormType::class, [
            'email' => $this->authenticationUtils->getLastUsername(),
        ]);
        
        return $this->render('admin/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }
}