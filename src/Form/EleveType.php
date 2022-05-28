<?php

namespace App\Form;

use App\Entity\Eleve;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photoFile', FileType::class, [
                "label" => "Photo Eleve",
                "mapped" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "mimeTypes" => [
                            'image/jpeg',
                            'image/png',
                        ]
                    ])

                ]
            ])
            ->add('matricule')
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('parent')
            ->add('classe')
            ->add('Ajouter', SubmitType::class, ["label" => "Ajouter un élève"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
