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
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotations\Groups;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;
use DateTime;




#[Route('/partenaireJSON')]
class ItemControllerJSON extends AbstractController
{
    #[Route('/display', name: 'list_itemsAJSON', methods: ['GET'])]
    public function showItemA(ItemRepository $ItemRepository, SerializerInterface $serializer ) : Response
    {
        $now = new \DateTime();
        $Items = $ItemRepository->findAll();
        $formatted = $serializer->serialize($Items,'json',['groups' => 'Items']);

        return new JsonResponse($formatted);
    }

 #[route('/addItem', name: 'add_itemJSON' , methods: ['GET', 'POST'])]
 public function addItem(Request $request, SerializerInterface $serializer) 
 {
    $item = new Item();
    $name = $request->query->get("name");
    $description = $request->query->get("description");
    $startTime = new \DateTime($request->query->get("start_time")) ;
    $endTime =  new \DateTime($request->query->get("end_time")) ;
    
    $startingPrice = $request->query->get("starting_price");
    $estimatedPrice = $request->query->get("estimated_price");
    $em = $this->getDoctrine()->getManager();
    $item->setName($name);
    $item->setDescription($description);
    $item->setStartTime($startTime);
    $item->setEndTime($endTime);
    $item->setStartingPrice($startingPrice);
    $item->setEstimatedPrice($estimatedPrice);
    $item->setStatus(0);
    $em->persist($item);
    $em->flush();
    $formatted = $serializer->serialize($item,'json',['groups' => 'Items']);

    return new JsonResponse($formatted);

 }
   
}
