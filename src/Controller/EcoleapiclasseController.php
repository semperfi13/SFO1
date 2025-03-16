<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleapiclasseController extends AbstractController
{
    /**
     * @Route("/api/classe", name="app_apiclasse", methods={"GET"})
     */
    public function index(ClasseRepository $classeRepo): Response

    {
        $classes = $classeRepo->findAll();
        return $this->json([
            'success' => true,
            'data' => $classes,
        ]);
    }
}
