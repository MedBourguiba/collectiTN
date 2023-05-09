<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserApiController extends AbstractController
{
    // #[Route('/loginJson', name: 'login_JSON', methods: ['GET','POST'])]
    // public function loginAction(Request $request , SerializerInterface $serializer): Response
    // {
    //     $email= $request->get("email");
    //     $password= $request->get("password");
    //     $em = $this->getDoctrine()->getManager();
    //     $user = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findOneBy(['email'=>$email]);

    //     if($user){
    //         if(password_verify($password,$user->getPassword())){
    //             $formatted = $serializer->serialize($user,'json',['groups' => 'Users']);
    //             return new JsonResponse($formatted, 200, [], true);

    //         }else{
                
    //        return new Response("password not found");
       

    //         }
    //     }else{
    //         return new Response("user not found");
    //     }

    // }
    #[Route('/loginJson', name: 'login_JSON', methods: ['GET','POST'])]
public function loginAction(Request $request , SerializerInterface $serializer): Response
{
    $email= $request->get("email");
    $password= $request->get("password");
    $em = $this->getDoctrine()->getManager();
    $user = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->findOneBy(['email'=>$email]);

    if($user){
        if(password_verify($password,$user->getPassword())){
            $formatted = $serializer->serialize($user,'json',['groups' => 'Users']);
$data = json_decode($formatted, true);
$data['photo_url'] = $user->getImg(); // add the image URL to the response
$formatted = $serializer->serialize($data, 'json');
return new JsonResponse($formatted, 200, [], true);
        }else{
            
       return new Response("password not found");
   

        }
    }else{
        return new Response("user not found");
    }

}


    #[Route('/edituser', name: 'profile_JSON', methods: ['PUT'])]
    public function profileAction(Request $request , SerializerInterface $serializer , UserPasswordEncoderInterface $passwordEncoder ): Response
    {    
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getManager()
                        ->getRepository(Utilisateur::class)
                        ->find($request->get("id"));
       
        $email= $request->get("email");
        $nom= $request->get("nom");
        $prenom= $request->get("prenom");
        $password= $request->get("password");
       
        $em = $this->getDoctrine()->getManager();
      
        $user-> setEmail($email);
        $user-> setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )
        );
        $user-> setNom($nom);
        $user-> setPrenom($prenom);
        $user-> setIsVerified(true);
   
        $em->persist($user);
        $em->flush();
        $formatted = $serializer->serialize($user,'json',['groups' => 'Users']);
        return new JsonResponse($formatted, 200, [], true);

    }
}