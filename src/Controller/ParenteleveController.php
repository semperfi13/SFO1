<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\EleveRepository;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParenteleveController extends AbstractController
{
    /**
     * @Route("/parent/eleve", name="app_parenteleve")
     */
    public function index(EleveRepository $eleveRepo): Response
    {

        $parentId = $this->getUser()->getId();
        //dd($parentId);
        $eleves = $eleveRepo->findBy(["parent" => $parentId], ["id" => "ASC"]);
        //dd($eleves);
        return $this->render('parenteleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }


    /**
     * @Route("/parent/eleve/note/{id<\d+>}", name="app_parenteleve_notes")
     */
    public function voirNote($id, NoteRepository $noteRepo, EleveRepository $elevesRepo): Response

    {
        $eleves = $elevesRepo->find($id);
        //dd($eleves);
        $notes = $eleves->getNotes();
        //$notes = $noteRepo->findBy(["eleve" => $id], ["id" => "ASC"]);
        //dd($notes);

        return $this->render('parenteleve/notes.html.twig', [
            'notes' => $notes,
            'eleve' => $eleves,
        ]);
    }
}
