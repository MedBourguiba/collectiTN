<?php

namespace App\Controller;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\Item;
use App\Entity\Utilisateur;
use App\Entity\Category;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotations\Groups;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Vich\UploaderBundle\Handler\UploadHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;





#[Route('/partenaireJSON')]
class ItemControllerJSON extends AbstractController

{

    #[Route('/details', name: 'details_itemJSON', methods: ['GET','POST'])]
    public function detailReclamationAction(Request $request , SerializerInterface $serializer )
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $item = $this->getDoctrine()->getManager()->getRepository(Item::class)->find($id);
        $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);
        return new JsonResponse($formatted, 200, [], true);
    }

    
  #[Route('/display', name: 'list_itemsAJSON', methods: ['GET','POST'])]
    public function showItemA(ItemRepository $ItemRepository, SerializerInterface $serializer , Request $request ) : Response
    {
        $now = new \DateTime();
        $user = $request->query->get("user");
        $id= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($user);
        $Items = $ItemRepository->findBy(['Partner' => $id]);
        $formatted = $serializer->serialize($Items,'json',['groups' => 'Items']);

        return new JsonResponse($formatted, 200, [], true);
    }

    #[Route('/addItem', name: 'add_itemJSON' , methods: ['POST','GET'])]
    public function addItem(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UploadHandler $vichUploaderHandler)
    {
        $item = new Item();
        $name = $request->query->get("name");
        $description = $request->query->get("description");
        $startTime = new \DateTime($request->query->get("start_time"));
        $endTime = new \DateTime($request->query->get("end_time"));
        $startingPrice = $request->query->get("starting_price");
        $estimatedPrice = $request->query->get("estimated_price");
        $Img = $request->query->get("img");
        $user = $request->query->get("user");
    
        $item->setName($name);
        $item->setDescription($description);
        $item->setStartTime($startTime);
        $item->setEndTime($endTime);
        $item->setStartingPrice($startingPrice);
        $item->setEstimatedPrice($estimatedPrice);
        $item->setImg($Img);
        $item->setStatus(0);
        $item->setPartner($this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($user));
        
    
        // Upload the image file and set the image URL
    
    
        $em->persist($item);
        $em->flush();
    
        $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);
        return new JsonResponse($formatted);
    }

    #[Route('/updateItem', name: 'update_itemJSON' , methods: ['PUT'])]
    public function updateItem(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UploadHandler $vichUploaderHandler)
    {
        $item = new Item();
        $item = $this->getDoctrine()->getManager()
        ->getRepository(Item::class)
        ->find($request->get("id"));
        $name = $request->query->get("name");
        $description = $request->query->get("description");
        $startTime = new \DateTime($request->query->get("start_time"));
        $endTime = new \DateTime($request->query->get("end_time"));
        $startingPrice = $request->query->get("starting_price");
        $estimatedPrice = $request->query->get("estimated_price");
        $Img = $request->query->get("img");
       
    
        $item->setName($name);
        $item->setDescription($description);
        $item->setStartTime($startTime);
        $item->setEndTime($endTime);
        $item->setStartingPrice($startingPrice);
        $item->setEstimatedPrice($estimatedPrice);
        $item->setImg($Img);
        $item->setStatus(0);
        $item->setPartner($item->getPartner());
        
    
        // Upload the image file and set the image URL
    
    
        $em->persist($item);
        $em->flush();
    
        $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);
        return new JsonResponse("Vente a ete modifiee avec success.");
    }

    #[Route('/deleteItem', name: 'delete_itemJSON' , methods: ['DELETE'])]  
    public function deleteItem(Request $request, SerializerInterface $serializer) {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->find($id);
        if($item!=null ) {
            $em->remove($item);
            try {
                $em->flush();
            } catch (\Throwable $th) {}

        
        return new JsonResponse("item a ete supprimee avec success.");

        }
        return new JsonResponse("id item invalide.");


    }

    
    #[Route('/details', name: 'details_itemJSON' , methods: ['POST','GET'])]  
     public function detailItemAction(Request $request, SerializerInterface $serializer)
     {
         $id = $request->get("id");

         $em = $this->getDoctrine()->getManager();
         $item = $this->getDoctrine()->getManager()->getRepository(Item::class)->find($id);
         $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);

         return new JsonResponse($formatted, 200, [], true);
     }

    #[Route('/uploadImage', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(Request $request, UploadHandler $uploadHandler): JsonResponse
    {
        $uploadedFile = $request->files->get('file');
        $fileName = $uploadedFile->getClientOriginalName(); // get the original file name
    
        // $uploadDirectory1 = $this->getParameter('item_images_directory');
        $uploadDirectory2 = $this->getParameter('item_images_uploads');
    
        // move the file to the first upload directory
        $uploadedFile->move($uploadDirectory2, $fileName);
    
        // make a copy of the file in the second upload directory
        // $fileCopyPath = $uploadDirectory2 . '/' . $fileName;
        // copy($uploadedFile->getPathname(), $fileCopyPath);
    
        return new JsonResponse(['fileName' => $fileName]);
    }
    
}
