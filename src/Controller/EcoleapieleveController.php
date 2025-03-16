<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EcoleapieleveController extends AbstractController
{
    /**
     * @Route("/api/eleves", name="app_ecole_api_eleves", methods={"GET"})
     */
    public function index(EleveRepository $eleveRepo): Response
    {
        $eleves = $eleveRepo->findAll();
        //
        $tab = [];

        foreach ($eleves as $eleve) {
            $tab[] = [
                "id" => $eleve->getId(),
                "nom" => $eleve->getNom(),

            ];
        }

        return $this->json($tab, 200);
    }

    /**
     * @Route("/api/eleves", name="app_ecole_api_eleves_create", methods={"POST"})
     */
    public function create(Request $request, EleveRepository $eleveRepo): Response
    {

         $data = $request->getContent();
         $data=json_decode($data,true);

         $eleve=new Eleve();
         $form = $this->createForm(EleveType::class, $eleve);
         $form->submit($data);
         if ($form->isSubmitted() && $form->isValid()) {
             $eleveRepo->add($eleve,true);
             $reponse=["id"=>$eleve->getId()];
             return $this->json(
                 [
                     "status"=>true,
                     "data"=>$reponse
                 ],201);
         }



         return $this->json(["status"=>false, "msg"=>"Erreur de données"], 400);




         /*


        $encoder = [new JsonEncode()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoder);
        $objetEleve = $serializer->deserialize($data, Eleve::class, '');

        dd($objetEleve); */
    }
    /**
     * @Route("/api/eleves/{id<\d+>}", name="app_ecole_api_eleves_create", methods={"POST"})
     */
    public function edit($id, Request $request, EleveRepository $eleveRepo): Response
    {
        $eleve=$eleveRepo->find($id);
        if ($eleve) {
        
            
        }
        $form = $this->createForm(EleveType::class, $eleve);
        $form->submit("");
        if ($form->isSubmitted() && $form->isValid()) {
            $eleveRepo->add($eleve, true);
            $reponse = ["id" => $eleve->getId()];
            return $this->json(
                [
                    "status" => true,
                    "data" => $reponse
                ],
                201
            );
        }



        return $this->json(["status" => false, "msg" => "Erreur de données"], 400);




}
}
