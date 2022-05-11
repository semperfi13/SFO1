<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NimporteController extends AbstractController
{
    /**
     * @Route("/nimporte", name="app_nimporte")
     */
    public function index(): Response
    {
        return $this->render('nimporte/index.html.twig', [
            'controller_name' => 'NimporteController',
        ]);
    }
}
