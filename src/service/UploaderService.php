<?php

namespace App\service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderService

{
    private $directory;

    public function uploader($dossier,UploadedFile $fichier, $nom = null)
    {
        $this->directory=$dossier;
        if (!$nom) {
            $nom = uniqid();
        }

        $nouveauNom = $nom . "." . $fichier->guessExtension();
        $fichier->move($this->directory, $nouveauNom);
        return $nouveauNom;
    }
}
