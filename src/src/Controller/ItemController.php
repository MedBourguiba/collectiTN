<?php

namespace App\Controller;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\Item;
use App\Entity\Category;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Component\Filesystem\Filesystem;

#[Route('/partenaire')]
class ItemController extends AbstractController
{
    #[Route('/', name: 'list_itemsA', methods: ['GET'])]
    public function showItemA(ItemRepository $ItemRepository): Response
    {
        $now = new \DateTime();
        return $this->render('Item/showA.html.twig', [
            'items' => $ItemRepository->findAll(),
            'now' => $now,
        ]);
    }

    #[Route('/show', name: 'list_itemsE', methods: ['GET'])]
    public function showItemE(ItemRepository $ItemRepository): Response
    {
        return $this->render('Item/showB.html.twig', [
            'items' => $ItemRepository->findAll(),
        ]);
    }

   

  


    #[Route('/add', name: 'add_item')]
    public function addItem(Request $request, ManagerRegistry $doctrine,ItemRepository $ItemRepository): Response
    {
        $item = new Item();
        $item->setStatus(0); // Set the default value for status to 0
        
        $form = $this->createForm(ItemType::class, $item);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded image file
            $imageFile = $form->get('img')->getData();

            if ($imageFile) {
                // Set the image name as the current timestamp and the original file extension
                $imageName = time() . '.' . $imageFile->getClientOriginalExtension();

                // Move the file to the configured directory using VichUploader
                $imageFile->move(
                    $this->getParameter('item_images_directory'),
                    $imageName
                );

                // Update the item entity with the new image filename

                $item->setImg($imageName);
            }

            $category=$form->get('category')->getData();
            $item->setCategory($category);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('list_itemsA');
        }

        return $this->render('item/add.html.twig', [
            'form' => $form->createView(),
            'items' => $ItemRepository->findAll()
        ]);
    }

    #[Route('/{id}/delete', name: 'delete_item')]
  
    public function deleteItem(Request $request, Item $item,ManagerRegistry $doctrine,ItemRepository $ItemRepository): Response
    {
        try {
            $filesystem = new Filesystem();
            $imagePath = $this->getParameter('item_images_directory').'/'.$item->getImg();
            if ($item->getImg() !== null && $filesystem->exists($imagePath)) {
                $filesystem->remove($imagePath);
            }
            if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
                $ItemRepository->remove($item, true);
            }
        } catch (\Exception $e) {
            // handle the exception, for example:
            $this->addFlash('error', 'An error occurred while deleting the item.');
            return $this->redirectToRoute('list_itemsE');
        }
    
        return $this->redirectToRoute('list_itemsE');
    }
    #[Route('/{id}/edit', name: 'edit_item')]
    public function editItem(Request $request, Item $item,ManagerRegistry $doctrine,ItemRepository $ItemRepository): Response
    {
        // Only allow editing items with a status of 1
        if ($item->getStatus() !== 1) {
            throw new AccessDeniedHttpException('You are not authorized to edit this item.');
        }
    
        $form = $this->createForm(ItemType::class, $item);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Get the uploaded image file
            $imageFile = $form['img']->getData();
    
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
                $imageFile->move(
                    $this->getParameter('item_images_directory'),
                    $newFilename
                );
            $data->setImg($newFilename);
            }
    
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
    
            return $this->redirectToRoute('list_itemsE');
        }
    
        return $this->render('item/edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
            'items' => $ItemRepository->findAll()
        ]);
    }
}
