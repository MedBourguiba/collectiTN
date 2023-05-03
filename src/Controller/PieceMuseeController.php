<?php

namespace App\Controller;

use App\Entity\PieceMusee;
use App\Form\PieceMuseeType;
use App\Repository\PieceMuseeRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/piece/musee')]
class PieceMuseeController extends AbstractController
{
    #[Route('/', name: 'app_piece_musee_index', methods: ['GET'])]
    public function index(PieceMuseeRepository $pieceMuseeRepository): Response
    {
        return $this->render('piece_musee/index.html.twig', [
            'piece_musees' => $pieceMuseeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_piece_musee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PieceMuseeRepository $pieceMuseeRepository): Response
    {
        $pieceMusee = new PieceMusee();
        $form = $this->createForm(PieceMuseeType::class, $pieceMusee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('img')->getData();

            if ($imageFile) {
                // Set the image name as the current timestamp and the original file extension
                $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

                // Move the file to the configured directory using VichUploader
                $imageFile->move(
                    $this->getParameter('Piece_musee_images_directory'),
                    $imageName
                );

                // Update the item entity with the new image filename

                $pieceMusee->setImg($imageName);
            }
            $pieceMusee->setPostedAt(new DateTimeImmutable("now"));
            $pieceMuseeRepository->save($pieceMusee, true);

            return $this->redirectToRoute('app_piece_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('piece_musee/new.html.twig', [
            'piece_musee' => $pieceMusee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piece_musee_show', methods: ['GET'])]
    public function show(PieceMusee $pieceMusee): Response
    {
        return $this->render('piece_musee/show.html.twig', [
            'piece_musee' => $pieceMusee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_piece_musee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PieceMusee $pieceMusee, PieceMuseeRepository $pieceMuseeRepository): Response
    {
        $form = $this->createForm(PieceMuseeType::class, $pieceMusee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pieceMuseeRepository->save($pieceMusee, true);

            return $this->redirectToRoute('app_piece_musee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('piece_musee/edit.html.twig', [
            'piece_musee' => $pieceMusee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_piece_musee_delete', methods: ['POST'])]
    public function delete(Request $request, PieceMusee $pieceMusee, PieceMuseeRepository $pieceMuseeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pieceMusee->getId(), $request->request->get('_token'))) {
            $pieceMuseeRepository->remove($pieceMusee, true);
        }

        return $this->redirectToRoute('app_piece_musee_index', [], Response::HTTP_SEE_OTHER);
    }
}
