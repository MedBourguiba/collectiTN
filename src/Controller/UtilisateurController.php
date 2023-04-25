<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository,Request $request): Response
    {
        $searchTerm = $request->query->get('Q');
        $utilisateurs = [];
        if (!empty($searchTerm)) {
            $utilisateurs = $utilisateurRepository->search($searchTerm);
        }
        else{
            $utilisateurs = $utilisateurRepository->findAll();
        }
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // generate a random password
            $password = bin2hex(random_bytes(8));
            $utilisateur->setPassword(
                $this->passwordEncoder->encodePassword($utilisateur, $password)
            );
            $utilisateurRepository->save($utilisateur, true);
    
            // send email to the user
            $email = (new Email())
                ->from('abourguiba510@gmail.com')
                ->to($utilisateur->getEmail())
                ->subject('Welcome to our site')
                ->text('Here is your temporary password: '.$password);
    
            $mailer->send($email);
    
            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
{
    // Check if the user has the required role to edit other users
    if (!$this->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedException('You are not authorized to edit this user.');
    }

    $form = $this->createForm(UtilisateurType::class, $utilisateur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $utilisateurRepository->save($utilisateur, true);

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('utilisateur/edit.html.twig', [
        'utilisateur' => $utilisateur,
        'form' => $form,
    ]);
}


#[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
{
    // Check if the user has the required role to delete other users
    if (!$this->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedException('You are not authorized to delete this user.');
    }

    if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
        $utilisateurRepository->remove($utilisateur, true);
    }

    return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
}
}
