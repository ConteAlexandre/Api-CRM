<?php

namespace App\Security;

use App\Form\Admin\AdminLoginFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

/**
 * Class AdminLoginAuthenticator
 */
final class AdminLoginAuthenticator extends AbstractFormLoginAuthenticator implements AuthenticatorInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * AdminLoginAuthenticator constructor.
     *
     * @param FormFactoryInterface         $factory
     * @param RouterInterface              $router
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(FormFactoryInterface $factory, RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->formFactory = $factory;
        $this->router = $router;
        $this->passwordEncoder = $encoder;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        if ($request->getPathInfo() != '/admin/login' || $request->getMethod() != 'POST') {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(AdminLoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['email']
        );

        return $data;
    }

    /**
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    /**
     * @param mixed         $credentials
     * @param UserInterface $user
     *
     * @return bool|string
     */
    public function checkCredentials($credentials, UserInterface $user)
     {
         return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
     }

    /**
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
     {
         $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
         return new RedirectResponse($this->router->generate('admin_login'));
     }

    /**
     * @return string
     */
    protected function getLoginUrl()
     {
         return $this->router->generate('admin_login');
     }

    /**
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
     {
         return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
     }
}