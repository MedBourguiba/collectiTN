<?php

namespace App\Controller;
use Symfony\Component\VarDumper\VarDumper;
use App\Entity\Item;
use App\Entity\Reclamation;
use App\Entity\Utilisateur;
use App\Entity\Category;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use App\Repository\ReclamationRepository;
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






class ReclamationControllerJSON extends AbstractController

{

    // #[Route('/details', name: 'details_itemJSON', methods: ['GET','POST'])]
    // public function detailReclamationAction(Request $request , SerializerInterface $serializer )
    // {
    //     $id = $request->get("id");

    //     $em = $this->getDoctrine()->getManager();
    //     $item = $this->getDoctrine()->getManager()->getRepository(Item::class)->find($id);
    //     $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);
    //     return new JsonResponse($formatted, 200, [], true);
    // }

    
#[Route('/display', name: 'list_ReclamationJSON', methods: ['GET','POST'])]
    public function showReclamation(ReclamationRepository $ReclamationRepository, SerializerInterface $serializer , Request $request ) : Response
    {
        $now = new \DateTime();
        $user = $request->query->get("user");
        $id= $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($user);
        $reclamations = $ReclamationRepository->findBy(['user' => $id]);
        $formatted = $serializer->serialize($reclamations,'json',['groups' => 'Reclamations']);

        return new JsonResponse($formatted, 200, [], true);
    }

    #[Route('/addreclamation', name: 'add_reclamationJSON' , methods: ['POST','GET'])]
    public function addItem(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UploadHandler $vichUploaderHandler)
    {    
        $now = new \DateTime();
        $reclamation = new reclamation();
        $sujet = $request->query->get("sujet");
        $message = $request->query->get("message");
        $date = new \DateTime('now');
        $name = $request->query->get("name");
        $email = $request->query->get("email");
        $user = $request->query->get("user");
    
        $reclamation->setSujet($sujet);
        $reclamation->setMessage($message);
        $reclamation->setName($name);
        $reclamation->setEmail($email);
        $reclamation->setDateReclamation($date);
        $reclamation->setUser($this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($user));
        $em->persist($reclamation);
        $em->flush();
    
        $formatted = $serializer->serialize($reclamation,'json',['groups' => 'Reclamations']);
        return new JsonResponse($formatted);
    }

    #[Route('/deletereclamation', name: 'delete_reclamationJSON' , methods: ['DELETE'])]
    public function deleteReclamationAction(Request $request,SerializerInterface $serializer,ReclamationRepository $ReclamationRepository) {
        $id = $request->get("id");
       
        $em = $this->getDoctrine()->getManager();
        $reclamations = $ReclamationRepository->findAll();
        $reclamation = $em->getRepository(Reclamation::class)->find($id);
      
        if($reclamation!=null ) {
            $em->remove($reclamation);
            $em->flush();
           
           
        $formatted = $serializer->serialize($reclamations,'json',['groups' => 'Reclamations']);
        return new JsonResponse($formatted, 200, [], true);
        }
        return new JsonResponse($serializer->serialize($reclamations,'json',['groups' => 'Reclamations']));


    }

    #[Route('/updatereclamation', name: 'update_reclamationJSON' , methods: ['PUT'])]
    public function modifierReclamationAction(Request $request,SerializerInterface $serializer) {
        $now = new \DateTime();
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()
                        ->getRepository(Reclamation::class)
                        ->find($request->get("id"));
                        $reclamation->setUser($reclamation->getUser());
                        $reclamation->setName($reclamation->getName());

                        $reclamation->setEmail($request->query->get("email"));
                        $reclamation->setSujet($request->query->get("sujet"));
                        $reclamation->setMessage($request->query->get("message"));

                        $reclamation->setDateReclamation(new \DateTime('now'));

        $em->persist($reclamation);
        $em->flush();
        
        $formatted = $serializer->serialize($reclamation,'json',['groups' => 'Reclamations']);
        return new JsonResponse("Reclamation a ete modifiee avec success.");
     

    } 
    
    
}
