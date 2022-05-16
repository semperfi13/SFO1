<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleclasseController extends AbstractController
{
    /**
     * @Route("/ecoleclasse", name="app_ecoleclasse")
     */
    public function index(): Response
    {
        return $this->render('ecoleclasse/index.html.twig', [
            'controller_name' => 'EcoleclasseController',
        ]);
    }
    /**
     * @Route("/ecoleclasse/add", name="app_ecoleclasse_add")
     */
    public function add(): Response

    {
        $classe = new Classe();

        $form = $this->createForm(ClasseType::class, $classe);
        return $this->render('ecoleclasse/add.html.twig', [
            "formulaire" => $form->createView(),
        ]);
    }
}
