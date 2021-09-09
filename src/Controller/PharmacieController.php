<?php

namespace App\Controller;

use App\Entity\Pharmacie;
use App\Form\PharmacieType;
use App\Repository\PharmacieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PharmacieController extends AbstractController
{
    private $pharmaRepo;
    private $serializer;
    private $manager;

    public function __construct(
        PharmacieRepository $pharmaRepo, 
        SerializerInterface $serializer,
        EntityManagerInterface $manager)
    {
        $this->pharmaRepo = $pharmaRepo;
        $this->serializer = $serializer;
        $this->manager = $manager;
    }
    
    /**
     * @Route("/pharma", name="pharma_index", methods={"GET"})
     */
    public function index(): Response
    {
        $pharmacies = $this->pharmaRepo->findAll();
        return $this->json($pharmacies,200,[''],["groups"=>"pharma"]);
    }

    /**
     * @Route("/pharma/{id}", name="pharma_read", methods={"GET"})
     */
    public function read($id): Response
    {
        $pharmacie = $this->pharmaRepo->find($id);
        return $this->json($pharmacie,200,[''],["groups"=>"pharma"]);
    }

    /**
     * @Route("/pharma", name="pharma_create", methods={"POST"})
     */
    public function create(Request $request, ValidatorInterface $validator): Response
    {
        try{
            $jsonRecu = $request->getContent();
            $newPharma = $this->serializer->deserialize($jsonRecu, Pharmacie::class, 'json');

            $error = $validator->validate($newPharma);
            if (count($error) > 0){
                return $this->json($error, 400);
            }
    
            $this->manager->persist($newPharma);
            $this->manager->flush();
    
            return $this->json($newPharma,201,[],["groups"=>"pharma"]);
        } catch (NotEncodableValueException $exception){
            return $this->json([
                "status"=> "400",
                "message"=>$exception->getMessage()
            ], 400);
        }
        
    }

    /**
     * @Route("/pharma/{id}", name="pharma_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $pharma = $this->pharmaRepo->find($id);

        if ($pharma==null){
            return $this->json([
                "status"=>500,
                "message"=>"aucune pharmacie trouvée"
            ]);
        } else {
            $this->manager->remove($pharma);
            $this->manager->flush();
    
            return $this->json([
                "status"=>200,
                "message"=>"pharmacie supprimée"
            ]);
        }  
    }

    /**
     * @Route("/pharma/{id}", name="pharma_update", methods={"PUT"})
     */
    public function update($id, Request $request): Response
    {
        try{
            $data = $request->getContent(); 
            $pharma = $this->pharmaRepo->find($id);
    
            if ($pharma==null){
                return $this->json([
                    "status"=>500,
                    "message"=>"aucune pharmacie trouvée"
                ]);
            } else {
                $pharma = $this->serializer->deserialize(
                    $data,
                    Pharmacie::class,
                    'json',
                    ['object_to_populate' => $pharma] // Populate deserialized JSON content into existing/new entity
                );
    
                $this->manager->persist($pharma);
                $this->manager->flush();
    
                return $this->json($pharma,200,[''],["groups"=>"pharma"]);
            }  
        } catch (NotEncodableValueException $exception){
            return $this->json([
                "status"=> "400",
                "message"=>$exception->getMessage()
            ], 400);
        } 
    }

    /**
     * @Route("/pharma-garde", name="pharma_garde", methods={"GET"})
     */
    public function garde(): Response
    {
        $pharmaGarde = $this->pharmaRepo->findGarde();

        if ($pharmaGarde==null){
            return $this->json([
                "status"=>"500",
                "message"=>"aucune pharmacie de garde aujourd'hui"
            ]);
        } else {
            return $this->json($pharmaGarde,200,[''],["groups"=>"pharma"]);
        }
    }
}
