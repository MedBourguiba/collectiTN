<?php

namespace App\Controller;

use App\Type\Enum\UserRoleEnum;
use App\Type\UserRoleEnumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SecurityController extends AbstractController
{
        private  $session;

        public function __construct(SessionInterface $session)
        {
            $this->session = $session;
        }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response

    {
        if ($this->getUser()) {
            $roles = $security->getUser()->getRoles();
            if (in_array(UserRoleEnum::ROLE_CLIENT, $roles)) {
                return $this->redirectToRoute('app_home');
            } elseif (in_array(UserRoleEnum::ROLE_PARTNER, $roles)) {
                return $this->redirectToRoute('list_itemsA');
            } elseif (in_array(UserRoleEnum::ROLE_ADMIN, $roles)) {
                return $this->redirectToRoute('app_back_office');
            }
            
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    public function sendTestEmail(MailerInterface $mailer): Response
{
    $email = (new Email())
        ->from('abourguiba510@gmail.com')
        ->to('abourguiba510@gmail.com')
        ->subject('Test email from Symfony Mailer')
        ->text('This is a test email from Symfony Mailer.');

    $mailer->send($email);

    return new Response('Test email sent.');
}

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        $this->session->invalidate();
        $this->get('security.token_storage')->setToken(null);
        $this->get('request_stack')->getCurrentRequest()->getSession()->invalidate();
        $this->addFlash('success', 'Vous avez été déconnecté.');
        return $this->redirectToRoute('app_login');
    }


      
}
