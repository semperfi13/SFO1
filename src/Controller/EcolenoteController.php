<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\ClasseRepository;
use App\Repository\NoteRepository;
use App\service\envoiNoteService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EcolenoteController extends AbstractController
{
    /**
     * @Route("/ecole/mail", name="app_ecolemail")
     */
    public function mail(MailerInterface $mailer)
    {
        $email = new Email();
        $email->from("adamsnikiema187@gmail.com")
            ->to("semperfinkm@gmail.com")
            ->subject("Test de email")
            ->text("Salut cher YENTECK");

        $mailer->send($email);
        dd("mail envoyé");
    }




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
            ->add("matiere", TextType::class)
            ->add("classe", EntityType::class, [
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
    public function addcontinuer(Request $request, ClasseRepository $classeRepo, NoteRepository $noteRepo, envoiNoteService $envoiNoteService): Response
    {

        //recupere les données du formulaire

        $dataForm = $request->get("form");
        $matiere = $dataForm["matiere"];
        $classeID = $dataForm["classe"];

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



        $formBuilder
            ->add("matiere", HiddenType::class, ["attr" => ["value" => $matiere]])
            ->add("classe", HiddenType::class, ["attr" => ["value" => $classeID]])
            ->add("Enregister", SubmitType::class);
        $form = $formBuilder->getForm();

        //handle request

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //

            $tableNotes = [];
            foreach ($eleves as $eleve) {
                $champName = "note_" . $eleve->getId();
                $noteEleve = $data[$champName];
                $note = new Note();
                $note->setMatiere($matiere)
                    ->setEleve($eleve)
                    ->setNote($noteEleve);

                $noteRepo->add($note, true);

                //envoyer mail

                $tableNotes[] = [
                    "email" => $eleve->getParent()->getEmail(),
                    "note" => $noteEleve,
                    "matiere" => $matiere,
                    "eleve" => $eleve->getPrenom(),

                ];
            }

            $envoiNoteService->envoyerNotes($tableNotes);



            $this->addFlash("succes", "Notes enregistrées");
            return $this->redirectToRoute("app_ecolenote");
        }


        return $this->render('ecolenote/add_continuer.html.twig', [
            "formulaire" => $form->createView(),
            "classe" => $classe
        ]);
    }

    /**
     *  @Route("/ecole/note/continuer/{id}/edit", name="app_ecolenote_add_continuer_edit")
     */
    public function editer(Note $note, Request $request, NoteRepository $noteRepo): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $noteRepo->add($note, true);
            $this->addFlash("success", "Note modifiée");
            return $this->redirectToRoute("app_ecolenote");
        }
        return $this->render('ecolenote/edit.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/ecole/note/continuer/{id}/delete", name="app_ecolenote_add_continuer_delete")
     */
    public function delete(Note $note, NoteRepository $noteRepo): Response
    {
        $noteRepo->remove($note, true);
        $this->addFlash("success", "Note supprimée");
        return $this->redirectToRoute("app_ecolenote");
    }
}
