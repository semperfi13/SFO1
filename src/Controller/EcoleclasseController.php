<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcoleclasseController extends AbstractController
{
    /**
     * @Route("/ecole/classe", name="app_ecoleclasse")
     */
    public function index(ClasseRepository $classeRepo): Response

    {
        $classes = $classeRepo->findAll();
        return $this->render('ecoleclasse/index.html.twig', [
            'classes' => $classes,
        ]);
    }
    /**
     * @Route("/ecole/classe/add", name="app_ecoleclasse_add")
     */
    public function add(Request $request, ClasseRepository $classeRepo): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $classeRepo->add($classe, true);
            $this->addFlash("w", "Classe ajoutée");

            return $this->redirectToRoute("app_ecoleclasse");
        }
        return $this->render('ecoleclasse/add.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/ecole/classe/{id}/editer", name="app_ecoleclasse_edit")
     */
    public function editer(Classe $classe, Request $request, ClasseRepository $classeRepo): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $classeRepo->add($classe, true);
            $this->addFlash("success", "Classe modifiée");
            return $this->redirectToRoute("app_ecoleclasse");
        }
        return $this->render('ecoleclasse/edit.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/ecole/classe/{id}/delete", name="app_ecoleclasse_delete")
     */
    public function delete(Classe $classe, ClasseRepository $classeRepo): Response
    {
        $classeRepo->remove($classe, true);
        $this->addFlash("success", "Classe supprimée");
        return $this->redirectToRoute("app_ecoleclasse");
    }
}
