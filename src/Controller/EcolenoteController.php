<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use App\Repository\NoteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EcolenoteController extends AbstractController
{
    /**
     * @Route("/ecole/note", name="app_ecolenote")
     */
    public function index(NoteRepository $noteRepo): Response
    {
        return $this->render('ecolenote/index.html.twig', [
            'notes' => $noteRepo->findBy([], ["id" => "DESC"]),
        ]);
    }

    /**
     * @Route("/ecole/note/add", name="app_ecolenote_add")
     */
    public function add(): Response
    {
        $form = $this->createFormBuilder()
            ->add("Matiere", TextType::class)
            ->add("Classe", EntityType::class, [
                "class" => Classe::class
            ])
            ->add("Continuer", SubmitType::class)
            ->setAction($this->generateUrl("app_ecolenote_add_continuer"))
            ->getForm();


        return $this->render('ecolenote/add.html.twig', [
            "formulaire" => $form->createView(),
        ]);
    }

    /**
     * @Route("/ecole/note/continuer", name="app_ecolenote_add_continuer")
     */
    public function addcontinuer(Request $request, ClasseRepository $classeRepo): Response
    {

        //recupere les données du formulaire
        $dataForm = $request->get("form");
        $matiere = $dataForm["Matiere"];
        $classeID = $dataForm["Classe"];
        //recupere les données de la base de données
        $classe = $classeRepo->find($classeID);
        $eleves = $classe->getEleves();
        //gener formulaire
        $formBuilder = $this->createFormBuilder();

        foreach ($eleves as $eleve) {
            $label = $eleve->getMatricule() . " - " . $eleve->getPrenom();
            $champName = "note_" . $eleve->getId();

            $formBuilder->add($champName, TextType::class, [
                "label" => $label
            ]);
        }

        $formBuilder->add("Enregister", SubmitType::class);
        $form = $formBuilder->getForm();

        return $this->render('ecolenote/add_continuer.html.twig', [
            "formulaire" => $form->createView(),
            "classe" => $classe
        ]);
    }
}
