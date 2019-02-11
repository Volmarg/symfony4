<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        $referer_url = (array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : null);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            if (!is_null($referer_url)) {
                return $this->redirect($referer_url);
            }
            return $this->redirect('/');
        } else {
            return $this->render('routes/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        }
    }

}
