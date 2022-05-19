<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleeleveController extends AbstractController
{
    /**
     * @Route("/ecole/eleve", name="app_ecoleeleve")
     */
    public function index(EleveRepository $eleveRepo): Response
    {
        $eleve = $eleveRepo->findAll();
        return $this->render('ecoleeleve/index.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @Route("/ecole/eleve/add", name="app_ecoleeleve_add")
     */
    public function add(Request $request, EleveRepository $eleveRepo): Response
    {
        $eleve = new Eleve();
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eleveRepo->add($eleve, true);
            $this->addFlash("w", "Elève ajoutée");

            return $this->redirectToRoute("app_ecoleeleve");
        }
        return $this->render('ecoleeleve/add.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }
    /**
     * @Route("/ecole/eleve/{id}/editer", name="app_ecoleeleve_edit")
     */
    public function editer(Eleve $eleve, Request $request, EleveRepository $eleveRepo): Response
    {
        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $eleveRepo->add($eleve, true);
            $this->addFlash("success", "Elève modifiée");
            return $this->redirectToRoute("app_ecoleeleve");
        }
        return $this->render('ecoleeleve/edit.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }
}
