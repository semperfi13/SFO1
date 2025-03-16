<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use App\Repository\HistoriqueConnexionRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory ;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EAPIClassesController extends AbstractController
{
    /**
     * @Route("/api/classes", name="api_classes",methods={"GET"})
     */
    public function index(HistoriqueConnexionRepository $repo,ClasseRepository $classeRepo): Response
    {

        return $this->json($repo->findAll());

        exit();
        $classes=$classeRepo->findAll();

        $normalizers=[new ObjectNormalizer(new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader())))];
        $encoders = [new JsonEncoder()]; 
        $serializer = new Serializer($normalizers, $encoders);

        $json= $serializer->serialize($classes,'json', ['groups' => ['id','nom']]);

        return $this->json( json_decode($json));
    }
}
