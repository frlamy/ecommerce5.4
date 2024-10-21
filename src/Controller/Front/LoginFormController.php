<?php

namespace App\Controller\Front;

use App\Form\Front\LoginType;
use App\Form\Front\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/utilisateur")
 */
class LoginFormController extends AbstractController
{
    /**
     * @Route("/connexion.html", name="app.login")
     * @Route("/inscription.html", name="app.register")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('account.edit');
         }

        $loginForm = $this->createForm(LoginType::class);

        $registrationForm = $this->createForm(RegistrationType::class);
        $registrationForm->handleRequest($request);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@template/security/form.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'loginForm' => $loginForm->createView(),
            'registrationForm' => $registrationForm->createView(),
        ]);
    }

    /**
     * @Route("/profil.html", name="account.edit")
     */
    public function editAction(): Response
    {
        dd('ici');
    }

    /**
     * @Route("/deconnexion.html", name="app.logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
