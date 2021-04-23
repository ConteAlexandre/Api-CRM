<?php

namespace App\Controller\User;

use App\Form\Account\PasswordFormType;
use App\Form\Account\ProfileFormType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{

    /**
     * @var UserManager $userManager
     */
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @Route("/profile", name="profile")
     * @return JsonResponse
     */
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/update/profile", name="updateProfile")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function updateProfil(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->save($user);

            $this->addFlash('success', 'The profile has been updated');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/password", name="updateUserPassword")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function updateUserPassword(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userManager->save($user);

            $this->addFlash('success', 'The password is updated!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('security/update_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
