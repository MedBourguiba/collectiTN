<?php

namespace App\Controller;

use App\Entity\Musee;
use App\Form\MuseeType;
use App\Repository\MuseeRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/musee')]
class MuseeController extends AbstractController
{
    #[Route('/', name: 'app_musee_index', methods: ['GET'])]
    public function index(MuseeRepository $museeRepository): Response
    {
        return $this->render('musee/index.html.twig', [
            'musees' => $museeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_musee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MuseeRepository $museeRepository): Response
    {
        
        $musee = new Musee();
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $imageFile = $form->get('img')->getData();

            if ($imageFile) {
                // Set the image name as the current timestamp and the original file extension
                $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

                // Move the file to the configured directory using VichUploader
                $imageFile->move(
                    $this->getParameter('musee_images_directory'),
                    $imageName
                );

                // Update the item entity with the new image filename

                $musee->setImg($imageName);
            }
            $musee->setCreatedAt(new DateTimeImmutable("now"));
            $museeRepository->save($musee, true);

            return $this->redirectToRoute('app_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('musee/new.html.twig', [
            'musee' => $musee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musee_show', methods: ['GET'])]
    public function show(Musee $musee): Response
    {
        return $this->render('musee/show.html.twig', [
            'musee' => $musee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_musee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Musee $musee, MuseeRepository $museeRepository): Response
    {
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $museeRepository->save($musee, true);

            return $this->redirectToRoute('app_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('musee/edit.html.twig', [
            'musee' => $musee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musee_delete', methods: ['POST'])]
    public function delete(Request $request, Musee $musee, MuseeRepository $museeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musee->getId(), $request->request->get('_token'))) {
            $museeRepository->remove($musee, true);
        }

        return $this->redirectToRoute('app_musee_index', [], Response::HTTP_SEE_OTHER);
    }
}