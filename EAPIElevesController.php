<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EAPIElevesController extends AbstractController
{
    /**
     * @Route("/api/eleves", name="api_eleves",methods={"GET"})
     */
    public function index(EleveRepository $eleveRepo): Response
    {
        $eleves=$eleveRepo->findAll();
        //
        $tab=[];

        foreach ($eleves as $eleve) {
            $tab[]=[
                "id"=>$eleve->getId(),
                "nom"=>$eleve->getNom(),
                "prenom"=>$eleve->getPrenom(),
                "parent"=>[
                    "id"=>$eleve->getParent()->getId(),
                    "nom"=>$eleve->getParent()->getNom(),
                    "email"=>$eleve->getParent()->getEmail(),
                ],
                "classe"=>[
                    "id"=>$eleve->getClasse()->getId(),
                    "nom"=>$eleve->getClasse()->getNom(),
                ],
                "notes"=>[],
                "retards"=>[]
            ];
        }
        //
        

        return $this->json($tab,200);
    }

    /**
     * @Route("/api/eleves", name="api_eleves_create",methods={"POST"})
     */
    public function create(Request $request,EleveRepository $eleveRepo): Response
    {
        $data=$request->getContent();
        $dataD=json_decode($data,true);

        $eleve=new Eleve();
        $form=$this->createForm(EleveType::class,$eleve);
        $form->submit($dataD);

        if($form->isSubmitted() && $form->isValid()){
            $eleveRepo->add($eleve,true);
            $reponse=["id"=>$eleve->getId()];

            return $this->json(
                [
                    "status"=>true,
                    "data"=>$reponse
                ],201);
        }
        
        return $this->json(["status"=>false,"msg"=>"Erreur de donnée"],400);
    
    }


    /**
     * @Route("/api/eleves/{id<\d+>}", name="api_eleves_edit",methods={"PUT"})
     */
    public function edit($id,Request $request,EleveRepository $eleveRepo): Response
    {
        //si eleve existe 
        $eleve=$eleveRepo->find($id);

        if($eleve){
            $data=$request->getContent();
            $dataD=json_decode($data,true);

            $form=$this->createForm(EleveType::class,$eleve);
            $form->submit($dataD,false);

            if($form->isSubmitted() && $form->isValid()){
                
                $eleveRepo->add($eleve,true);
                $reponse=[
                    "id"=>$eleve->getId(),
                    "nom"=>$eleve->getNom(),
                    "prenom"=>$eleve->getPrenom(),
                ];
    
                return $this->json(
                    [
                        "status"=>true,
                        "data"=>$reponse
                    ],200);
            }
            
            return $this->json(["status"=>false,"msg"=>"Erreur de donnée"],400);
            
        }

        return $this->json(["status"=>false,"msg"=>"Eleve introuvale"],404);
    
    }


        /**
     * @Route("/api/eleves/{id<\d+>}", name="api_eleves_delete",methods={"DELETE"})
     */
    public function delete($id,Request $request,EleveRepository $eleveRepo): Response
    {
        //si eleve existe 
        $eleve=$eleveRepo->find($id);

        if($eleve){
            
            $eleveRepo->remove($eleve,true);

            return $this->json(null,204);            
        }
        return $this->json(["status"=>false,"msg"=>"Eleve introuvale"],404);
    
    }

}

/*

//
        $encoders = [new JsonEncoder()]; // If no need for XmlEncoder
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        // Serialize your object in Json
        $jsonObject = $serializer->serialize($eleves, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        //
        $json = $serializer->serialize($eleves,'json', ['groups' => ['eleves']]);
        dd($json);

        return $this->json(json_decode($jsonObject));

*/