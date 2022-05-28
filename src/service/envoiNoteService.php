<?php
namespace App\service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class envoiNoteService {
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    public function envoyerNotes($tableNotes)
    {
        foreach($tableNotes as $tab)

        {
            $emailParent=$tab["email"];
            $note=$tab["note"];
            $matiere=$tab["matiere"];
            $eleve=$tab["email"];

            //generation du email

            $msg ="Note de $eleve en $matiere : $note";

            $mail = new Email();

            $mail-> from("adamsnikiema187@gmail.com")
            ->to($emailParent)
            ->subject("Envoi des notes")
            ->text($msg);
            $this->mailer->send($mail);

        }
    }

}
