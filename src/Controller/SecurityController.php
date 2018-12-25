<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Gestion de la déconnexion.
     * @Route("/logout", name="app_logout")
     * @return [type] [description]
     */
    public function logout()
    {
    	return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Requets $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
    	if ($request->isMethod('POST')) {
    		$user = new User();
    		$user->setEmail($request->request->get('email'));
    		$user->setNomComplet($request->request->get('nomComplet'));
    		$user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($user);
    		$em->flush();
    		return $this->redirectToRoute('homepage');

    	}

    	return $this->render('security/register.html.twig');
    }

    
}
